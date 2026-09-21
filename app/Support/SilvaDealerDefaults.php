<?php

namespace App\Support;

use App\Support\Concerns\HasLocalizedDefaults;

class SilvaDealerDefaults
{
    use HasLocalizedDefaults;

    protected static function baseData(): array
    {
        return [
            'intro' => [
                'kicker' => 'Bayi Ol',
                'title' => 'Bayilik başvuru ve bilgi talep formu',
                'text' => 'Bayilik başvurusu ve yurtdışı satış için bu formu doldurun. Sizinle en yakın zamanda iletişime geçeceğiz.',
                'hours' => 'Gerçek yaşamın değerlerini büyütün.',
            ],
            'channels' => [
                ['type' => 'phone', 'icon' => 'bx-phone', 'label' => 'Telefon', 'value' => '+90 850 346 02 26', 'url' => 'tel:+908503460226'],
                ['type' => 'email', 'icon' => 'bx-envelope', 'label' => 'E-posta', 'value' => 'bilgi@acarkon.com', 'url' => 'mailto:bilgi@acarkon.com'],
                ['type' => 'store', 'icon' => 'bx-store-alt', 'label' => 'Showroom', 'value' => 'Horozluhan Mahallesi Hotamış Sk. No:49 Selçuklu / Konya', 'url' => '/tr/magazalar'],
            ],
            'form' => [
                'experience_title' => 'İş deneyimi',
                'company_title' => 'Firma bilgileri',
                'type_title' => 'Bayilik türü',
                'notes_title' => 'Ek notlarınız',
                'name_label' => 'Ad',
                'name_placeholder' => 'Adınız',
                'surname_label' => 'Soyad',
                'surname_placeholder' => 'Soyadınız',
                'phone_label' => 'Telefon no',
                'phone_placeholder' => '05xx xxx xx xx',
                'email_label' => 'E-posta adresi',
                'email_placeholder' => 'ornek@mail.com',
                'website_label' => 'Websitesi',
                'website_placeholder' => 'https://',
                'company_label' => 'Firma adı',
                'company_placeholder' => 'Firma veya ünvan',
                'address_label' => 'Firma adresi',
                'address_placeholder' => 'Açık adres',
                'city_label' => 'Şehir',
                'city_placeholder' => 'Şehir',
                'town_label' => 'İlçe',
                'town_placeholder' => 'İlçe',
                'tax_office_label' => 'Vergi dairesi',
                'tax_office_placeholder' => 'Vergi dairesi',
                'tax_no_label' => 'Vergi no',
                'tax_no_placeholder' => 'Vergi numarası',
                'activity_label' => 'Faaliyet alanı',
                'activity_placeholder' => 'Örn. zemin kaplama, iç mimari',
                'refs_label' => 'Referanslar',
                'refs_placeholder' => 'Varsa referanslarınız',
                'type_domestic' => 'Yurtiçi bayilik',
                'type_abroad' => 'Yurtdışı bayilik',
                'message_placeholder' => 'Paylaşmak istediğiniz ek bilgi...',
                'consent_html' => 'Kişisel verilerin <a href="__KVKK__">aydınlatma metni</a> ve <a href="__PRIVACY__">gizlilik politikası</a> kapsamında işlenmesini kabul ediyorum.',
                'submit_label' => 'Başvuru yap',
                'success_message' => 'Teşekkürler — başvurunuz alındı. En kısa sürede sizinle iletişime geçeceğiz.',
            ],
        ];
    }
}
