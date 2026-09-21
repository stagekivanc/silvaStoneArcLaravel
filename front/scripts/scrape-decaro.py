#!/usr/bin/env python3
import json
import os
import re
import time
from concurrent.futures import ThreadPoolExecutor, as_completed
from html import unescape
from urllib.request import Request, urlopen

BASE = "https://www.decaro.ru"
ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
IMG_ROOT = os.path.join(ROOT, "assets", "products")
UA = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36"
HEADERS = {"User-Agent": UA, "Accept-Language": "en,tr,ru;q=0.8"}

COLLECTIONS = [
    {"key": "metal", "name": "Metal", "url": f"{BASE}/catalog/wallpanels/decaro_wallpanels/metal_4/"},
    {"key": "signature", "name": "Signature Wood", "url": f"{BASE}/catalog/wallpanels/decaro_wallpanels/signature_wood/"},
    {"key": "textile", "name": "Textile", "url": f"{BASE}/catalog/wallpanels/decaro_wallpanels/textile_1/"},
    {"key": "wood", "name": "Wood", "url": f"{BASE}/catalog/wallpanels/decaro_wallpanels/wood/"},
]

SKIP_NAME = re.compile(
    r"uglovoy|soedinitel|tenevym|napoln|perekhod|tortsevoy|zazorom|po-stene|oboyami",
    re.I,
)


def fetch(url, retries=3):
    last = None
    for i in range(retries):
        try:
            req = Request(url, headers=HEADERS)
            with urlopen(req, timeout=45) as r:
                return r.read(), r.geturl()
        except Exception as e:
            last = e
            time.sleep(0.5 * (i + 1))
    raise last


def fetch_text(url):
    data, final = fetch(url)
    return data.decode("utf-8", "replace"), final


def abs_url(src):
    src = unescape(src or "").strip()
    if src.startswith("//"):
        return "https:" + src
    if src.startswith("/"):
        return BASE + src
    return src


def basename(src):
    return os.path.basename(src.split("?")[0])


def field(html, cls):
    m = re.search(
        rf'field-{re.escape(cls)}[\s\S]{{0,280}}?product-internal__title">\s*([^<]+)',
        html,
    )
    return unescape(m.group(1)).strip() if m else ""


def ext_from_bytes(data, url):
    if data[:8] == b"\x89PNG\r\n\x1a\n":
        return ".png"
    if data[:3] == b"\xff\xd8\xff":
        return ".jpg"
    if data[:4] == b"RIFF" and data[8:12] == b"WEBP":
        return ".webp"
    path = url.split("?")[0].lower()
    for e in (".png", ".webp", ".jpg", ".jpeg", ".gif"):
        if path.endswith(e):
            return ".jpg" if e == ".jpeg" else e
    return ".jpg"


def parse_listing(html):
    links = []
    seen = set()
    for href in re.findall(r'href="(/catalog/wallpanels/decaro_wallpanels/[^"]+/\d+/)"', html):
        if href in seen:
            continue
        seen.add(href)
        links.append(BASE + href)
    return links


def gallery(html):
    block = ""
    m = re.search(r'<div class="product-slider__area">([\s\S]*?)<div class="product-slider__footer">', html)
    if m:
        block = m.group(1)
    imgs = []
    seen_names = set()
    for src in re.findall(r'<div class="slide[^"]*"[^>]*>\s*<img[^>]+src="([^"]+)"', block):
        src = unescape(src)
        if "px.png" in src or "90_90" in src:
            continue
        name = basename(src)
        if SKIP_NAME.search(name):
            continue
        key = re.sub(r"\.(jpg|jpeg|png|webp)$", "", name, flags=re.I).lower()
        if key in seen_names:
            continue
        seen_names.add(key)
        imgs.append(src)
    return imgs


def parse_product(html, url, col):
    title = ""
    m = re.search(r'product-title(?:--mobile)? t-h4">\s*([^<]+)', html)
    if m:
        title = unescape(m.group(1)).strip()
    code = ""
    cm = re.search(r"\b(D\d+[A-Z]?)\b", title)
    if cm:
        code = cm.group(1)
    imgs = gallery(html)
    if not code and imgs:
        cm = re.search(r"(D\d+[A-Z]?)", basename(imgs[0]), re.I)
        if cm:
            code = cm.group(1).upper()
    return {
        "url": url,
        "title": title,
        "code": code,
        "design": field(html, "dizayn"),
        "collection": field(html, "kollektsiya") or col["name"],
        "cat": col["key"],
        "thick_raw": field(html, "tolshchina"),
        "height": re.sub(r"[^0-9]", "", field(html, "vysota_mm")),
        "width": re.sub(r"[^0-9]", "", field(html, "shirina_mm")),
        "material": field(html, "sostav"),
        "depot": bool(re.search(r"В наличии", html)),
        "remote_imgs": imgs,
    }


def download_one(code, index, src):
    url = abs_url(src)
    data, final = fetch(url)
    if not data or len(data) < 1200:
        raise RuntimeError(f"tiny {url}")
    ext = ext_from_bytes(data, final)
    folder = os.path.join(IMG_ROOT, code.lower())
    os.makedirs(folder, exist_ok=True)
    rel = f"assets/products/{code.lower()}/{index + 1:02d}{ext}"
    dest = os.path.join(ROOT, rel)
    with open(dest, "wb") as f:
        f.write(data)
    return rel, len(data)


def main():
    os.makedirs(IMG_ROOT, exist_ok=True)
    products = []
    print("=== listings ===", flush=True)
    for col in COLLECTIONS:
        html, _ = fetch_text(col["url"])
        links = parse_listing(html)
        print(f"{col['name']}: {len(links)} ürün", flush=True)
        for link in links:
            time.sleep(0.12)
            ph, _ = fetch_text(link)
            p = parse_product(ph, link, col)
            print(
                f"  {p['code'] or '?'} | {p['design']} | {p['width']}x{p['height']} | {p['thick_raw']} | {len(p['remote_imgs'])} görsel",
                flush=True,
            )
            products.append(p)

    jobs = []
    for p in products:
        p["local_imgs"] = [None] * len(p["remote_imgs"])
        for i, src in enumerate(p["remote_imgs"]):
            jobs.append((p["code"], i, src))

    print(f"\n=== images ({len(jobs)}) ===", flush=True)
    ok = fail = 0
    with ThreadPoolExecutor(max_workers=5) as ex:
        futs = {ex.submit(download_one, code, i, src): (code, i) for code, i, src in jobs}
        for fut in as_completed(futs):
            code, i = futs[fut]
            try:
                rel, size = fut.result()
                for p in products:
                    if p["code"] == code:
                        p["local_imgs"][i] = rel
                        break
                ok += 1
                print(f"  OK {code} {i + 1} {size // 1024}KB {rel}", flush=True)
            except Exception as e:
                fail += 1
                print(f"  FAIL {code} {i + 1} {e}", flush=True)

    out = os.path.join(IMG_ROOT, "_raw.json")
    with open(out, "w", encoding="utf-8") as f:
        json.dump(products, f, ensure_ascii=False, indent=2)
    print(f"\nDONE products={len(products)} ok={ok} fail={fail}", flush=True)
    print("wrote", out, flush=True)


if __name__ == "__main__":
    main()
