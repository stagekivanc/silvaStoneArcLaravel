<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategoryTranslation;
use App\Models\ProductColor;
use App\Models\ProductColorTranslation;
use App\Models\ProductFeature;
use App\Models\ProductFeatureTranslation;
use App\Models\ProductTranslation;
use App\Support\SilvaProductsDefaults;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArcCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $this->syncFrontToUploads();

        $payloadPath = database_path('data/arc_products.json');
        if (! is_file($payloadPath)) {
            $this->command?->warn('arc_products.json bulunamadı, Arc katalog seed atlandı.');

            return;
        }

        $payload = json_decode(file_get_contents($payloadPath), true) ?: [];
        $this->seedProductsPage();
        $this->seedColors($payload['colors'] ?? []);
        $categoryIds = $this->seedCategories($payload['categories'] ?? []);
        $this->deactivateLegacyStoneCatalog(array_values($categoryIds));
        $this->seedProductFeatures();
        $this->seedProducts($payload['products'] ?? [], $payload['featured'] ?? [], $categoryIds);
    }

    /**
     * Laravel artık public/silvastone kullanmaz; front statikleri uploads altına kopyalanır.
     */
    private function syncFrontToUploads(): void
    {
        $front = base_path('front');
        $uploads = public_path('uploads');
        if (! is_dir($front)) {
            return;
        }

        foreach (['assets', 'css', 'js'] as $dir) {
            $from = $front . DIRECTORY_SEPARATOR . $dir;
            $to = $uploads . DIRECTORY_SEPARATOR . $dir;
            if (! is_dir($from)) {
                continue;
            }
            if (! is_dir($to)) {
                mkdir($to, 0755, true);
            }
            $this->mirrorDirectory($from, $to);
        }
    }

    private function mirrorDirectory(string $from, string $to): void
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($from, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $target = $to . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            if ($item->isDir()) {
                if (! is_dir($target)) {
                    mkdir($target, 0755, true);
                }
                continue;
            }
            $targetDir = dirname($target);
            if (! is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            if (! is_file($target) || filemtime($item->getPathname()) > filemtime($target)) {
                copy($item->getPathname(), $target);
            }
        }
    }

    private function seedProductsPage(): void
    {
        $defaults = SilvaProductsDefaults::data('tr');
        $defaultsEn = SilvaProductsDefaults::data('en');

        $page = Page::updateOrCreate(
            ['type' => 'products'],
            [
                'slug' => 'urunler',
                'name' => 'Ürünler',
                'title' => 'Panel Koleksiyonu',
                'seo_title' => 'Ürünler | Silva Arc Panel Koleksiyonu',
                'seo_description' => 'Silva Arc Panel Wood, Metal, Kök ve Traverten serileri. 60×280×8 mm dekoratif duvar panelleri.',
                'seo_keywords' => 'Silva Arc Panel, Wood, Metal, Kök, Traverten, dekoratif duvar paneli',
                'extras' => $defaults,
            ]
        );

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'lang_key' => 'tr'],
            [
                'slug' => 'urunler',
                'name' => 'Ürünler',
                'title' => 'Panel Koleksiyonu',
                'seo_title' => 'Ürünler | Silva Arc Panel Koleksiyonu',
                'seo_description' => 'Silva Arc Panel Wood, Metal, Kök ve Traverten serileri. 60×280×8 mm dekoratif duvar panelleri.',
                'seo_keywords' => 'Silva Arc Panel, Wood, Metal, Kök, Traverten, dekoratif duvar paneli',
                'extras' => $defaults,
            ]
        );

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'lang_key' => 'en'],
            [
                'slug' => 'products',
                'name' => 'Products',
                'title' => 'Panel Collection',
                'seo_title' => 'Products | Silva Arc Panel Collection',
                'seo_description' => 'Silva Arc Panel Wood, Metal, Root and Travertine series. 60×280×8 mm decorative wall panels.',
                'seo_keywords' => 'Silva Arc Panel, Wood, Metal, Root, Travertine, decorative wall panel',
                'extras' => $defaultsEn,
            ]
        );
    }

    private function seedColors(array $colors): void
    {
        foreach ($colors as $index => $color) {
            $slug = $color['slug'] ?? null;
            if (! $slug) {
                continue;
            }

            $model = ProductColor::updateOrCreate(
                ['slug' => $slug],
                [
                    'hex' => $color['hex'] ?? '#cccccc',
                    'order' => $color['order'] ?? ($index + 1),
                    'status' => true,
                ]
            );

            ProductColorTranslation::updateOrCreate(
                ['product_color_id' => $model->id, 'lang_key' => 'tr'],
                ['name' => $color['name'] ?? $slug]
            );
            ProductColorTranslation::updateOrCreate(
                ['product_color_id' => $model->id, 'lang_key' => 'en'],
                ['name' => $color['name_en'] ?? ($color['name'] ?? $slug)]
            );
        }
    }

    private function seedCategories(array $categories): array
    {
        $ids = [];
        foreach ($categories as $cat) {
            $slug = $cat['slug'] ?? null;
            if (! $slug) {
                continue;
            }

            $model = ProductCategory::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $cat['name'] ?? $slug,
                    'order' => $cat['order'] ?? 0,
                    'status' => true,
                    'home_status' => true,
                ]
            );

            ProductCategoryTranslation::updateOrCreate(
                ['product_category_id' => $model->id, 'lang_key' => 'tr'],
                [
                    'name' => $cat['name'] ?? $slug,
                    'slug' => $slug,
                ]
            );
            ProductCategoryTranslation::updateOrCreate(
                ['product_category_id' => $model->id, 'lang_key' => 'en'],
                [
                    'name' => $cat['name_en'] ?? ($cat['name'] ?? $slug),
                    'slug' => $slug,
                ]
            );

            $ids[$slug] = $model->id;
        }

        return $ids;
    }

    private function seedProductFeatures(): void
    {
        // Stone-era filters (600×1200, outdoor) → Arc front/urunler.html chips
        $desired = [
            ['slug' => 'size-60x280', 'filter_key' => 'size', 'filter_value' => '60x280', 'order' => 1, 'tr' => '60×280', 'en' => '60×280'],
            ['slug' => 'thick-8', 'filter_key' => 'thick', 'filter_value' => '8', 'order' => 2, 'tr' => '8 mm', 'en' => '8 mm'],
            ['slug' => 'depot', 'filter_key' => 'depot', 'filter_value' => '1', 'order' => 3, 'tr' => 'Stokta', 'en' => 'In stock'],
        ];

        $keep = [];
        foreach ($desired as $row) {
            $item = ProductFeature::updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'filter_key' => $row['filter_key'],
                    'filter_value' => $row['filter_value'],
                    'order' => $row['order'],
                    'status' => true,
                ]
            );
            $keep[] = $item->id;

            ProductFeatureTranslation::updateOrCreate(
                ['product_feature_id' => $item->id, 'lang_key' => 'tr'],
                ['name' => $row['tr']]
            );
            ProductFeatureTranslation::updateOrCreate(
                ['product_feature_id' => $item->id, 'lang_key' => 'en'],
                ['name' => $row['en']]
            );
        }

        ProductFeature::query()
            ->whereNotIn('id', $keep)
            ->update(['status' => false]);
    }

    private function deactivateLegacyStoneCatalog(array $keepCategoryIds): void
    {
        ProductCategory::query()
            ->whereIn('slug', ['stonex', 'stoneart'])
            ->update(['status' => false, 'home_status' => false]);

        $legacyIds = ProductCategory::query()->whereIn('slug', ['stonex', 'stoneart'])->pluck('id');
        if ($legacyIds->isNotEmpty()) {
            Product::query()
                ->whereIn('category_id', $legacyIds)
                ->update(['status' => false, 'home_status' => false]);
        }

        unset($keepCategoryIds);
    }

    private function seedProducts(array $products, array $featured, array $categoryIds): void
    {
        $featuredMap = array_flip($featured);

        foreach ($products as $index => $item) {
            $catSlug = $item['cat'] ?? 'wood';
            $categoryId = $categoryIds[$catSlug] ?? reset($categoryIds);
            $code = trim((string) ($item['code'] ?? ''));
            $nameTr = trim((string) ($item['name'] ?? $code));
            $nameEn = trim((string) ($item['name_en'] ?? $nameTr));
            $slugBase = Str::slug($code ?: $nameTr) ?: ('urun-' . ($index + 1));

            $main = SilvaProductsDefaults::normalizeMedia($item['img'] ?? null);
            $gallery = [];
            foreach ((array) ($item['imgs'] ?? []) as $img) {
                $normalized = SilvaProductsDefaults::normalizeMedia($img);
                if ($normalized) {
                    $gallery[] = $normalized;
                }
            }

            $material = trim((string) ($item['material'] ?? 'Ahşap-polimer kompozit (WPC)'));
            $shortTr = $material . '. Yalnızca iç mekâna uygundur.';
            $shortEn = 'Wood-polymer composite (WPC). Indoor use only.';

            $product = Product::updateOrCreate(
                ['sku' => $code !== '' ? $code : $slugBase],
                [
                    'category_id' => $categoryId,
                    'name' => $nameTr,
                    'slug' => $slugBase,
                    'color' => $item['color'] ?? null,
                    'panel_size' => $item['size'] ?? '60x280',
                    'size_extra' => $item['sizeExtra'] ?? 'Talep üzerine',
                    'thick' => $item['thick'] ?? '8',
                    'indoor' => (bool) ($item['indoor'] ?? true),
                    'outdoor' => (bool) ($item['outdoor'] ?? false),
                    'depot' => (bool) ($item['depot'] ?? true),
                    'technical_specs' => ['material' => $material],
                    'main_image' => $main,
                    'hover_image' => null,
                    'source_url' => null,
                    'gallery' => $gallery,
                    'order' => $index + 1,
                    'status' => true,
                    'home_status' => isset($featuredMap[$code]),
                    'short_description' => $shortTr,
                    'description' => null,
                    'seo_title' => preg_replace('/\s+Duvar Paneli$/u', '', $nameTr) . ' | Silva Arc Panel',
                    'seo_description' => $nameTr . ' — Silva Arc Panel dekoratif duvar paneli.',
                ]
            );

            ProductTranslation::updateOrCreate(
                ['product_id' => $product->id, 'lang_key' => 'tr'],
                [
                    'name' => $nameTr,
                    'slug' => $slugBase,
                    'title' => preg_replace('/\s+Duvar Paneli$/u', '', $nameTr),
                    'short_description' => $shortTr,
                    'seo_title' => preg_replace('/\s+Duvar Paneli$/u', '', $nameTr) . ' | Silva Arc Panel',
                    'seo_description' => $nameTr . ' — Silva Arc Panel dekoratif duvar paneli.',
                ]
            );

            ProductTranslation::updateOrCreate(
                ['product_id' => $product->id, 'lang_key' => 'en'],
                [
                    'name' => $nameEn,
                    'slug' => $slugBase,
                    'title' => preg_replace('/\s+Wall Panel$/i', '', $nameEn),
                    'short_description' => $shortEn,
                    'seo_title' => preg_replace('/\s+Wall Panel$/i', '', $nameEn) . ' | Silva Arc Panel',
                    'seo_description' => $nameEn . ' — Silva Arc Panel decorative wall panel.',
                ]
            );
        }
    }
}
