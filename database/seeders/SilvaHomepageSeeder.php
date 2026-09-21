<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Setting;
use App\Support\SilvaHomepageDefaults;
use Illuminate\Database\Seeder;

class SilvaHomepageSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = SilvaHomepageDefaults::data('tr');

        $page = Page::updateOrCreate(
            ['type' => 'index'],
            [
                'slug' => 'anasayfa',
                'name' => 'Anasayfa',
                'title' => 'Silva Arc Panel',
                'seo_title' => 'Silva Arc Panel | Acarkon Dekoratif Duvar Panelleri',
                'seo_description' => 'Silva Arc Panel by Acarkon — modern iç mekânlar için dekoratif duvar panelleri. Wood, Metal, Kök ve Traverten serileri; hızlı montaj, Acarkon Store ağı.',
                'seo_keywords' => 'Silva Arc Panel, Acarkon, dekoratif duvar paneli, arc panel, feature wall, iç mekân kaplama, Konya',
                'extras' => $defaults,
            ]
        );

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'lang_key' => 'tr'],
            [
                'slug' => 'anasayfa',
                'name' => 'Anasayfa',
                'title' => 'Silva Arc Panel',
                'seo_title' => 'Silva Arc Panel | Acarkon Dekoratif Duvar Panelleri',
                'seo_description' => 'Silva Arc Panel by Acarkon — modern iç mekânlar için dekoratif duvar panelleri. Wood, Metal, Kök ve Traverten serileri; hızlı montaj, Acarkon Store ağı.',
                'seo_keywords' => 'Silva Arc Panel, Acarkon, dekoratif duvar paneli, arc panel, feature wall, iç mekân kaplama, Konya',
                'extras' => $defaults,
            ]
        );

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'lang_key' => 'en'],
            [
                'slug' => 'home',
                'name' => 'Home',
                'title' => 'Silva Arc Panel',
                'seo_title' => 'Silva Arc Panel | Acarkon Decorative Wall Panels',
                'seo_description' => 'Silva Arc Panel by Acarkon — decorative wall panels for modern interiors. Wood, Metal, Root and Travertine series with fast install.',
                'seo_keywords' => 'Silva Arc Panel, Acarkon, decorative wall panel, arc panel, feature wall',
                'extras' => SilvaHomepageDefaults::data('en'),
            ]
        );

        $settings = [
            'site_name' => 'Silva Arc Panel',
            'site_tagline' => 'Acarkon dekoratif duvar panelleri',
            'company_name' => 'Acarkon Orman Ürünleri',
            'phone' => '+90 850 346 02 26',
            'phone_raw' => '+908503460226',
            'email' => 'bilgi@acarkon.com',
            'address' => 'Horozluhan Mahallesi Hotamış Sk. No:49 Selçuklu / Konya',
            'whatsapp' => '908503460226',
            'instagram' => 'https://www.instagram.com/acarkon/',
            'facebook' => 'https://www.facebook.com/',
            'youtube' => 'https://www.youtube.com/',
            'catalog_url' => 'silvastone/assets/silva-stone-2026-katalog.pdf',
            'footer_cta_title' => 'Mekânınız için doğru yüzeyi seçin',
            'footer_cta_text' => 'Katalogu inceleyin veya en yakın Acarkon Store’dan numune alın.',
            'footer_brand_text' => 'Silva Arc Panel, Acarkon Orman Ürünleri ürün ailesinin dekoratif duvar paneli markasıdır.',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
