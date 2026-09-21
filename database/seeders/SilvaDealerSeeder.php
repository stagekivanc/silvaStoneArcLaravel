<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageTranslation;
use App\Support\SilvaDealerDefaults;
use Illuminate\Database\Seeder;

class SilvaDealerSeeder extends Seeder
{
    public function run(): void
    {
        $defaultsTr = SilvaDealerDefaults::data('tr');
        $defaultsEn = SilvaDealerDefaults::data('en');

        $page = Page::updateOrCreate(
            ['type' => 'dealer'],
            [
                'slug' => 'bayilik-basvuru',
                'name' => 'Bayilik Başvuru',
                'title' => 'Bayilik Başvuru',
                'seo_title' => 'Bayilik Başvuru | Silva Stone',
                'seo_description' => 'Silva Stone bayi ağına katılmak için bayilik başvuru formunu doldurun.',
                'seo_keywords' => 'Silva Stone bayilik, bayi başvuru, Acarkon bayi',
                'extras' => $defaultsTr,
            ]
        );

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'lang_key' => 'tr'],
            [
                'slug' => 'bayilik-basvuru',
                'name' => 'Bayilik Başvuru',
                'title' => 'Bayilik Başvuru',
                'seo_title' => 'Bayilik Başvuru | Silva Stone',
                'seo_description' => 'Silva Stone bayi ağına katılmak için bayilik başvuru formunu doldurun.',
                'seo_keywords' => 'Silva Stone bayilik, bayi başvuru, Acarkon bayi',
                'extras' => $defaultsTr,
            ]
        );

        PageTranslation::updateOrCreate(
            ['page_id' => $page->id, 'lang_key' => 'en'],
            [
                'slug' => 'dealer-application',
                'name' => 'Dealer Application',
                'title' => 'Dealer Application',
                'seo_title' => 'Dealer Application | Silva Stone',
                'seo_description' => 'Apply to join the Silva Stone dealer network.',
                'seo_keywords' => 'Silva Stone dealer, dealer application, Acarkon dealer',
                'extras' => $defaultsEn,
            ]
        );
    }
}
