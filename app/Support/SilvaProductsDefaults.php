<?php

namespace App\Support;

use App\Support\Concerns\HasLocalizedDefaults;

class SilvaProductsDefaults
{
    use HasLocalizedDefaults;

    protected static function baseData(): array
    {
        return [
            'intro' => [
                'kicker' => 'Silva Arc Panel',
                'title' => 'Silva Arc Panel Koleksiyonu',
                'aside' => 'Wood, Metal, Kök ve Traverten serileri. İç mekân için dekoratif duvar panelleri.',
            ],
            'filter' => [
                'all' => 'Hepsi',
                'filter_label' => 'Filtre',
                'filter_title' => 'Filtrele',
                'color_label' => 'Renk',
                'feature_label' => 'Özellik',
                'reset' => 'Sıfırla',
                'apply' => 'Ürünleri gör',
                'empty' => 'Bu seçime uygun ürün yok.',
                'empty_reset' => 'Filtrelemeyi sıfırla',
                'count_suffix' => 'ürün',
                'size_60x280' => '60×280',
                'thick_8' => '8 mm',
                'depot' => 'Stokta',
            ],
            'seo' => [
                'kicker' => 'Rehber',
                'title' => 'Silva Arc Panel Koleksiyonu',
                'more' => 'Devamını oku',
                'body' => [
                    'Silva Arc Panel Koleksiyonu Wood, Metal, Kök ve Traverten serilerinde toplanır. Paneller 60×280×8 mm ölçüde üretilir. Numune ve sipariş için Acarkon Store ağı üzerinden ekibe ulaşabilirsiniz.',
                    'Ahşap-polimer kompozit (WPC) yapı iç mekâna metal, kök ahşap, kumaş ve doğal ağaç dokuları taşır; neme dayanıklı yüzeyiyle uzun ömürlü bir kaplama oluşturur.',
                    'Wood Serisi meşe ve ceviz panelleri; Metal Serisi şampanya, inox, titanyum ve antrasit yüzeyleri; Kök Serisi kök kaplama karakterini; Traverten Serisi bej, fildişi ve terra dokularını kapsar.',
                    'Numune, metraj ve uygulama için Acarkon Store ağı veya iletişim formu üzerinden ekibe ulaşın.',
                ],
            ],
            'detail' => [
                'related_kicker' => 'Silva Arc Panel Koleksiyonu',
                'related_title' => 'Benzer yüzeyler',
                'related_from' => ':cat koleksiyonundan',
                'spec_code' => 'Ürün kodu',
                'spec_collection' => 'Koleksiyon',
                'spec_color' => 'Renk',
                'spec_size' => 'Ölçü',
                'spec_thick' => 'İncelik',
                'spec_extra' => 'Özel sipariş',
                'mm' => 'mm',
                'indoor' => 'İç mekana uygun',
                'outdoor' => 'Dış mekana uygun',
                'depot' => 'Stokta',
                'add_cart' => 'Sepete ekle',
                'quote' => 'Teklif al',
                'qty' => 'Adet',
                'image_pending' => 'Ürün resmi hazırlanıyor',
                'collection_crumb' => 'Silva Arc Panel Koleksiyonu',
            ],
        ];
    }

    public static function formatSize(?string $size): string
    {
        $size = trim((string) $size);
        if ($size === '') {
            return '60×280';
        }

        return str_replace(['x', 'X'], '×', $size);
    }

    public static function formatThick(?string $thick): string
    {
        return str_replace('-', '–', trim((string) $thick));
    }

    public static function normalizeMedia(?string $path): ?string
    {
        $path = trim((string) $path);
        if ($path === '') {
            return null;
        }
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        $normalized = ltrim($path, '/');
        if (str_starts_with($normalized, 'silvastone/')) {
            return $normalized;
        }
        if (str_starts_with($normalized, 'assets/')) {
            return 'silvastone/' . $normalized;
        }

        return $normalized;
    }
}
