<?php

namespace App\Support;

use App\Support\Concerns\HasLocalizedDefaults;

class SilvaHomepageDefaults
{
    use HasLocalizedDefaults;

    protected static function baseData(): array
    {
        return [
            'hero' => [
                'primary_label' => 'Koleksiyonu incele',
                'primary_url' => '/tr/urunler',
                'secondary_label' => 'Showroom',
                'secondary_url' => '/tr/magazalar',
                'slides' => [
                    [
                        'image' => 'uploads/assets/products/mt012/04.jpg',
                        'kicker' => 'Silva Arc Panel · Metal Serisi',
                        'title' => 'Mimari yüzey',
                        'lead' => 'Fırçalanmış metal dokulu paneller; resepsiyon, kolon ve feature wall’da keskin bir mimari karakter.',
                        'tone' => 'dark',
                    ],
                    [
                        'image' => 'uploads/assets/hero/2.jpg',
                        'kicker' => 'Silva Arc Panel · Wood Serisi',
                        'title' => 'Doğal doku',
                        'lead' => 'Meşe ve ceviz karakterli paneller; konut ve otel iç mekânlarında sakin, sıcak bir yüzey dili.',
                        'tone' => 'dark',
                    ],
                    [
                        'image' => 'uploads/assets/hero/1.jpg',
                        'kicker' => 'Silva Arc Panel · Traverten Serisi',
                        'title' => 'Doğal derinlik',
                        'lead' => 'Traverten dokulu paneller; lobi ve feature wall’da yumuşak, doğal bir mimari odak.',
                        'tone' => 'dark',
                    ],
                ],
            ],
            'intro' => [
                'eyebrow' => 'Acarkon ürün ailesi',
                'title' => 'Arc panelin karakterini, hafif ve uygulanabilir bir yüzeyle iç mekâna taşıyoruz.',
                'text' => 'Silva Arc Panel; otel lobilerinden konut feature wall’larına kadar, mimari odağı güçlendiren dekoratif duvar panelleri sunar. Numune ve sipariş için Türkiye genelindeki Acarkon Store’ları ziyaret edin.',
            ],
            'features' => [
                'title' => 'Silva Arc Panel neden tercih edilir',
                'subtitle' => 'Tasarım, uygulama ve kullanım için malzemenin temel özellikleri',
                'catalog_label' => 'Panel özelliklerini inceleyin',
                'catalog_url' => '/tr/urunler',
                'items' => [
                    ['title' => 'Çevre dostu', 'text' => 'Ahşap-polimer kompozit malzeme; konut, ofis, çocuk ve sağlık mekânları için güvenli, bakımı kolay bir yüzey sunar.'],
                    ['title' => 'Meşeden daha güçlü', 'text' => 'Janka’da 4000+ lbf’ye kadar sertlik; klasik ahşap türlerinden 2–3 kat daha güçlü. Darbe, sürtünme ve yoğun ticari trafiğe dayanır.'],
                    ['title' => '35 doku', 'text' => 'Eşsiz koleksiyon: doğal örgülerden minimalist desenlere. Farklı stillere uygun doku, efekt ve kombinasyonlarla tasarımı netleştirir.'],
                    ['title' => 'Kolay kurulum', 'text' => 'Yapışkan veya mekanik bağlantı. Panel 60×280×8 mm, ağırlığı ~4 kg/m². Kaba ve ince işte katı hazırlık şartı yoktur; teslim süresini kısaltır.'],
                    ['title' => 'Yangına dayanıklılık', 'text' => 'Yanıcı sınıf G1 (düşük yanıcı). KM2 sertifikası (G1, B2, D2, T2) ve EN B sınıfı uyum; ticari tesis onayları için tam belge seti.'],
                    ['title' => 'Evrensellik', 'text' => 'Duvar, tavan, mobilya ve bölme. Kolon, niş, yarıçap ve standart dışı birleşimlerde bütün bir yüzey.'],
                    ['title' => 'Nem dayanımı', 'text' => 'Nemli iç mekânlarda yüzeyini korur; bakımı kolay bir kaplama sunar.'],
                    ['title' => 'Sıcaklık değişimine dayanım', 'text' => 'İç mekânda sıcaklık değişiminde çatlamaz, geometrisini korur.'],
                ],
            ],
            'products' => [
                'eyebrow' => 'Wood, Metal, Kök ve Traverten serileri. İç mekân için dekoratif duvar panelleri.',
                'title' => 'Panel Koleksiyonu',
                'subtitle' => 'Wood, Metal, Kök ve Traverten serileri. İç mekân için dekoratif duvar panelleri.',
                'cta_label' => 'Tüm ürünler',
                'cta_url' => '/tr/urunler',
            ],
            'spaces' => [
                'title' => 'Mekânlara karakter',
                'subtitle' => 'Feature wall, lobi ve ticari yüzeylerde doğal derinlik.',
                'items' => [
                    [
                        'icon' => 'bx-home-alt-2',
                        'title' => 'Konutlar',
                        'text' => 'TV duvarı, şömine nişi ve oturma odasında sakin accent yüzey.',
                        'url' => '/tr/urunler',
                    ],
                    [
                        'icon' => 'bx-hotel',
                        'title' => 'Oteller',
                        'text' => 'Lobi, resepsiyon ve oda koridorlarında mimari odak duvarı.',
                        'url' => '/tr/urunler',
                    ],
                    [
                        'icon' => 'bx-briefcase-alt-2',
                        'title' => 'Ofis mekânları',
                        'text' => 'Toplantı odası ve marka duvarında sakin, bakımı kolay yüzey.',
                        'url' => '/tr/urunler',
                    ],
                    [
                        'icon' => 'bx-restaurant',
                        'title' => 'Restoranlar',
                        'text' => 'Salon ve bar duvarında doku, leke direnci ve hızlı temizlik.',
                        'url' => '/tr/urunler',
                    ],
                    [
                        'icon' => 'bx-spa',
                        'title' => 'Klinik & spa',
                        'text' => 'Neme dayanıklı, hijyenik ve sessiz bir iç mekân yüzeyi.',
                        'url' => '/tr/iletisim',
                    ],
                    [
                        'icon' => 'bx-store-alt',
                        'title' => 'Ticari alanlar',
                        'text' => 'Mağaza, showroom ve giriş alanlarında doğal panel karakteri.',
                        'url' => '/tr/urunler',
                    ],
                ],
            ],
            'stores' => [
                'eyebrow' => 'Showroom',
                'title' => 'Showroom & satış noktaları',
                'subtitle' => 'Silva Arc Panel’i Acarkon Store’larda görün, dokunun ve sipariş edin.',
                'cta_label' => 'Tüm showroom’ları gör',
                'cta_url' => '/tr/magazalar',
            ],
        ];
    }
}
