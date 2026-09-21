<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Setting;
use App\Models\StaticTranslation;
use App\Support\SilvaHomepageDefaults;
use Illuminate\Database\Seeder;

class SilvaArcHomepageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::query()->where('type', 'index')->first();
        if (! $page) {
            return;
        }

        $meta = [
            'tr' => [
                'seo_title' => 'Silva Arc Panel | Acarkon Dekoratif Duvar Panelleri',
                'seo_description' => 'Silva Arc Panel by Acarkon — modern iç mekânlar için dekoratif duvar panelleri. Wood, Metal, Kök ve Traverten serileri.',
                'seo_keywords' => 'Silva Arc Panel, Acarkon, dekoratif duvar paneli, arc panel, feature wall, iç mekân kaplama, Konya',
            ],
            'en' => [
                'seo_title' => 'Silva Arc Panel | Acarkon Decorative Wall Panels',
                'seo_description' => 'Silva Arc Panel by Acarkon — decorative wall panels for modern interiors. Wood, Metal, Root and Travertine series.',
                'seo_keywords' => 'Silva Arc Panel, Acarkon, decorative wall panel, arc panel, feature wall',
            ],
        ];

        $trExtras = SilvaHomepageDefaults::data('tr');
        unset($trExtras['projects']);

        $page->fill([
            'title' => 'Silva Arc Panel',
            'seo_title' => $meta['tr']['seo_title'],
            'seo_description' => $meta['tr']['seo_description'],
            'seo_keywords' => $meta['tr']['seo_keywords'],
            'extras' => $trExtras,
        ])->save();

        foreach ($meta as $lang => $seo) {
            $translation = $page->translations()->where('lang_key', $lang)->first();
            if (! $translation) {
                continue;
            }

            $extras = SilvaHomepageDefaults::data($lang);
            unset($extras['projects']);

            $translation->extras = $extras;
            $translation->title = $lang === 'en' ? 'Home' : 'Anasayfa';
            $translation->seo_title = $seo['seo_title'];
            $translation->seo_description = $seo['seo_description'];
            $translation->seo_keywords = $seo['seo_keywords'];
            $translation->save();
        }

        Setting::set('site_name', 'Silva Arc Panel');
        Setting::set('site_tagline', 'Acarkon dekoratif duvar panelleri');
        Setting::set('footer_brand_text', 'Silva Arc Panel, Acarkon Orman Ürünleri ürün ailesinin dekoratif duvar paneli markasıdır.');

        $ui = [
            'nav_collection' => ['tr' => 'Panel Koleksiyonu', 'en' => 'Panel Collection'],
            'nav_dealer' => ['tr' => 'Bayi Ol', 'en' => 'Become a dealer'],
            'footer_brand_text' => [
                'tr' => 'Silva Arc Panel, Acarkon Orman Ürünleri ürün ailesinin dekoratif duvar paneli markasıdır.',
                'en' => 'Silva Arc Panel is the decorative wall panel brand of the Acarkon Forest Products family.',
            ],
            'footer_dealer' => ['tr' => 'Bayi Ol', 'en' => 'Become a dealer'],
            'search_meta_title' => ['tr' => 'Arama Sonuçları | Silva Arc Panel', 'en' => 'Search Results | Silva Arc Panel'],
            'ui_all' => ['tr' => 'Hepsi', 'en' => 'All'],
        ];

        foreach ($ui as $key => $langs) {
            foreach ($langs as $lang => $value) {
                StaticTranslation::updateOrCreate(
                    ['lang_key' => $lang, 'group' => 'frontend', 'key' => $key],
                    ['value' => $value]
                );
            }
        }
    }
}
