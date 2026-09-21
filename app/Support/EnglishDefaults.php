<?php

namespace App\Support;

class EnglishDefaults
{
    public static function for(string $class): array
    {
        return match ($class) {
            SilvaProductsDefaults::class => self::silvaProducts(),
            SilvaContactDefaults::class => self::silvaContact(),
            SilvaDealerDefaults::class => self::silvaDealer(),
            SilvaHomepageDefaults::class => self::silvaHomepage(),
            SilvaStoresDefaults::class => self::silvaStores(),
            SilvaProjectsDefaults::class => self::silvaProjects(),
            SilvaContractsDefaults::class => self::silvaContracts(),
            default => [],
        };
    }

    private static function silvaHomepage(): array
    {
        return [
            'hero' => [
                'primary_label' => 'Explore the collection',
                'primary_url' => '/en/products',
                'secondary_label' => 'Showroom',
                'secondary_url' => '/en/stores',
                'slides' => [
                    [
                        'image' => 'uploads/assets/products/mt012/04.jpg',
                        'kicker' => 'Silva Arc Panel · Metal Series',
                        'title' => 'Architectural surface',
                        'lead' => 'Brushed metal-textured panels — a sharp architectural character for reception, columns and feature walls.',
                        'tone' => 'dark',
                    ],
                    [
                        'image' => 'uploads/assets/hero/2.jpg',
                        'kicker' => 'Silva Arc Panel · Wood Series',
                        'title' => 'Natural texture',
                        'lead' => 'Oak and walnut character panels — a calm, warm surface language for homes and hotels.',
                        'tone' => 'dark',
                    ],
                    [
                        'image' => 'uploads/assets/hero/1.jpg',
                        'kicker' => 'Silva Arc Panel · Travertine Series',
                        'title' => 'Natural depth',
                        'lead' => 'Travertine-textured panels — a soft, natural architectural focus for lobbies and feature walls.',
                        'tone' => 'dark',
                    ],
                ],
            ],
            'intro' => [
                'eyebrow' => 'Acarkon product family',
                'title' => 'We bring Arc panel character indoors as a light, easy-to-apply surface.',
                'text' => 'Silva Arc Panel offers decorative wall panels that strengthen architectural focus — from hotel lobbies to residential feature walls. Visit Acarkon Stores across Türkiye for samples and orders.',
            ],
            'features' => [
                'title' => 'Why choose Silva Arc Panel',
                'subtitle' => 'Core material qualities for design, installation and everyday use',
                'catalog_label' => 'Browse panel features',
                'catalog_url' => '/en/products',
                'items' => [
                    ['title' => 'Eco-friendly', 'text' => 'Wood–polymer composite — a safe, easy-care surface for homes, offices, kids’ and healthcare spaces.'],
                    ['title' => 'Stronger than oak', 'text' => 'Up to 4000+ lbf on the Janka scale — 2–3× stronger than classic woods. Resists impact, abrasion and heavy commercial traffic.'],
                    ['title' => '35 textures', 'text' => 'A unique collection from natural weaves to minimal patterns — clear design with texture, effect and combinations.'],
                    ['title' => 'Easy install', 'text' => 'Adhesive or mechanical fixing. Panel 60×280×8 mm, ~4 kg/m². No heavy prep on rough or finish work; shortens lead times.'],
                    ['title' => 'Fire resistance', 'text' => 'Combustibility class G1 (low). KM2 certificate (G1, B2, D2, T2) and EN B alignment — full documentation for commercial approvals.'],
                    ['title' => 'Versatility', 'text' => 'Walls, ceilings, furniture and partitions. A continuous surface on columns, niches, radii and non-standard joints.'],
                    ['title' => 'Moisture resistance', 'text' => 'Protects its surface in humid interiors; an easy-care cladding.'],
                    ['title' => 'Thermal stability', 'text' => 'Does not crack under indoor temperature swings; keeps its geometry.'],
                ],
            ],
            'products' => [
                'eyebrow' => 'Wood, Metal, Root and Travertine series. Decorative wall panels for interiors.',
                'title' => 'Panel Collection',
                'subtitle' => 'Wood, Metal, Root and Travertine series. Decorative wall panels for interiors.',
                'cta_label' => 'All products',
                'cta_url' => '/en/products',
            ],
            'spaces' => [
                'title' => 'Character for every space',
                'subtitle' => 'Natural depth for feature walls, lobbies and commercial surfaces.',
                'items' => [
                    ['icon' => 'bx-home-alt-2', 'title' => 'Homes', 'text' => 'Calm accent surfaces for TV walls, fireplace niches and living rooms.', 'url' => '/en/products'],
                    ['icon' => 'bx-hotel', 'title' => 'Hotels', 'text' => 'Architectural focus walls for lobbies, reception and corridors.', 'url' => '/en/products'],
                    ['icon' => 'bx-briefcase-alt-2', 'title' => 'Offices', 'text' => 'Calm, easy-care surfaces for meeting rooms and brand walls.', 'url' => '/en/products'],
                    ['icon' => 'bx-restaurant', 'title' => 'Restaurants', 'text' => 'Texture, stain resistance and quick cleaning for dining and bar walls.', 'url' => '/en/products'],
                    ['icon' => 'bx-spa', 'title' => 'Clinic & spa', 'text' => 'Moisture-resistant, hygienic and quiet interior surface.', 'url' => '/en/contact'],
                    ['icon' => 'bx-store-alt', 'title' => 'Retail', 'text' => 'Natural panel character for stores, showrooms and entrances.', 'url' => '/en/products'],
                ],
            ],
            'stores' => [
                'eyebrow' => 'Showroom',
                'title' => 'Showrooms & sales points',
                'subtitle' => 'See, touch and order Silva Arc Panel at Acarkon Stores.',
                'cta_label' => 'View all showrooms',
                'cta_url' => '/en/stores',
            ],
        ];
    }

    private static function silvaStores(): array
    {
        $items = collect(SilvaStoresDefaults::data('tr')['items'] ?? [])
            ->map(function (array $item) {
                if (trim((string) ($item['address'] ?? '')) === 'Yakında') {
                    $item['address'] = 'Coming soon';
                }

                return $item;
            })
            ->values()
            ->all();

        return [
            'intro' => [
                'kicker' => 'Showroom',
                'title' => 'Sales points',
                'aside' => 'See, touch and order Silva Arc Panel at Acarkon Stores. The same phone line applies at every location.',
            ],
            'filter' => [
                'city_label' => 'City',
                'all_cities' => 'All cities',
                'near_label' => 'Nearest to me',
            ],
            'items' => $items,
        ];
    }

    private static function silvaProjects(): array
    {
        return [
            'intro' => [
                'kicker' => 'Applications',
                'title' => 'Projects',
                'aside' => 'From hotel lobbies to villa facades. Filter by indoor, outdoor and city.',
            ],
            'filter' => [
                'place_label' => 'Place',
                'type_label' => 'Type',
                'all_cities' => 'All cities',
                'count_suffix' => 'projects',
                'reset' => 'Reset',
                'empty_title' => 'No projects match this selection.',
                'empty_reset' => 'Clear filters',
            ],
            'detail' => [
                'notes_kicker' => 'Application',
                'notes_title' => 'Notes',
                'related_kicker' => 'Explore',
                'related_title' => 'Other applications',
                'story_kicker' => 'Story',
                'surface_kicker' => 'Surface',
                'surface_hint' => 'Panel used',
                'cta' => 'Talk about this application',
                'type_projects' => 'projects',
                'facts' => [
                    'city' => 'City',
                    'place' => 'Place',
                    'type' => 'Type',
                    'product' => 'Surface',
                    'year' => 'Year',
                    'area' => 'Area',
                ],
            ],
        ];
    }

    private static function silvaContracts(): array
    {
        return [
            'intro' => [
                'kicker' => 'Legal',
                'title' => 'Contracts',
                'aside' => 'Privacy, notice, cookies, security and KVKK texts. Each contract has its own page.',
            ],
            'items' => collect(SilvaLegalDefaults::types())
                ->map(fn (array $meta, string $type) => [
                    'type' => $type,
                    'number' => $meta['number'],
                    'label' => $meta['name_en'] ?? $meta['name'],
                ])
                ->values()
                ->all(),
        ];
    }

    private static function silvaContact(): array
    {
        return [
            'intro' => [
                'kicker' => 'Contact',
                'title' => "Let's talk about your project",
                'text' => 'Fill in the form for samples, quantities or a showroom visit. Our team will get back to you shortly.',
                'hours' => 'Weekdays 09:00 – 18:00',
            ],
            'channels' => [
                ['type' => 'phone', 'icon' => 'bx-phone', 'label' => 'Phone', 'value' => '+90 850 346 02 26', 'url' => 'tel:+908503460226'],
                ['type' => 'email', 'icon' => 'bx-envelope', 'label' => 'Email', 'value' => 'bilgi@acarkon.com', 'url' => 'mailto:bilgi@acarkon.com'],
                ['type' => 'whatsapp', 'icon' => 'bxl-whatsapp', 'label' => 'WhatsApp', 'value' => '+90 850 346 02 26', 'url' => 'https://wa.me/908503460226'],
                ['type' => 'hours', 'icon' => 'bx-time-five', 'label' => 'Working hours', 'value' => 'Weekdays 09:00 – 18:00', 'url' => ''],
                ['type' => 'address', 'icon' => 'bx-map', 'label' => 'Showroom', 'value' => 'Horozluhan Mahallesi Hotamış Sk. No:49 Selçuklu / Konya', 'url' => ''],
            ],
            'form' => [
                'name_label' => 'Full name',
                'name_placeholder' => 'Your first and last name',
                'phone_label' => 'Phone',
                'phone_placeholder' => '05xx xxx xx xx',
                'email_label' => 'Email',
                'email_placeholder' => 'example@mail.com',
                'city_label' => 'City',
                'city_placeholder' => 'Project city',
                'interest_label' => 'Topic of interest',
                'message_label' => 'Project note',
                'message_placeholder' => 'Space type, approximate area or a short note...',
                'consent_html' => 'I accept the processing of personal data under the <a href="__KVKK__">privacy notice</a> and <a href="__PRIVACY__">privacy policy</a>.',
                'submit_label' => 'Send request',
                'success_message' => 'Thank you — we will get back to you shortly.',
                'interests' => [
                    ['value' => 'catalog', 'label' => 'Collection / sample'],
                    ['value' => 'project', 'label' => 'Project & quantity'],
                    ['value' => 'store', 'label' => 'Showroom visit'],
                    ['value' => 'other', 'label' => 'Other'],
                ],
            ],
            'map' => [
                'title' => 'Headquarters location',
                'iframe_title' => 'Acarkon Showroom Konya',
            ],
        ];
    }

    private static function silvaDealer(): array
    {
        return [
            'intro' => [
                'kicker' => 'Become a dealer',
                'title' => 'Dealer application and information form',
                'text' => 'Fill in this form for dealership applications and international sales. We will contact you shortly.',
                'hours' => 'Growing the values of real life.',
            ],
            'channels' => [
                ['type' => 'phone', 'icon' => 'bx-phone', 'label' => 'Phone', 'value' => '+90 850 346 02 26', 'url' => 'tel:+908503460226'],
                ['type' => 'email', 'icon' => 'bx-envelope', 'label' => 'Email', 'value' => 'bilgi@acarkon.com', 'url' => 'mailto:bilgi@acarkon.com'],
                ['type' => 'store', 'icon' => 'bx-store-alt', 'label' => 'Showroom', 'value' => 'Horozluhan Mahallesi Hotamış Sk. No:49 Selçuklu / Konya', 'url' => '/en/stores'],
            ],
            'form' => [
                'experience_title' => 'Work experience',
                'company_title' => 'Company details',
                'type_title' => 'Dealership type',
                'notes_title' => 'Additional notes',
                'name_label' => 'First name',
                'name_placeholder' => 'Your first name',
                'surname_label' => 'Last name',
                'surname_placeholder' => 'Your last name',
                'phone_label' => 'Phone number',
                'phone_placeholder' => '05xx xxx xx xx',
                'email_label' => 'Email address',
                'email_placeholder' => 'example@mail.com',
                'website_label' => 'Website',
                'website_placeholder' => 'https://',
                'company_label' => 'Company name',
                'company_placeholder' => 'Company or title',
                'address_label' => 'Company address',
                'address_placeholder' => 'Full address',
                'city_label' => 'City',
                'city_placeholder' => 'City',
                'town_label' => 'District',
                'town_placeholder' => 'District',
                'tax_office_label' => 'Tax office',
                'tax_office_placeholder' => 'Tax office',
                'tax_no_label' => 'Tax number',
                'tax_no_placeholder' => 'Tax number',
                'activity_label' => 'Field of activity',
                'activity_placeholder' => 'e.g. flooring, interior design',
                'refs_label' => 'References',
                'refs_placeholder' => 'References if any',
                'type_domestic' => 'Domestic dealership',
                'type_abroad' => 'International dealership',
                'message_placeholder' => 'Any additional information...',
                'consent_html' => 'I accept the processing of personal data under the <a href="__KVKK__">privacy notice</a> and <a href="__PRIVACY__">privacy policy</a>.',
                'submit_label' => 'Submit application',
                'success_message' => 'Thank you — your application has been received. We will contact you shortly.',
            ],
        ];
    }

    private static function silvaProducts(): array
    {
        return [
            'intro' => [
                'kicker' => 'Silva Arc Panel',
                'title' => 'Silva Arc Panel Collection',
                'aside' => 'Wood, Metal, Root and Travertine series. Decorative wall panels for interiors.',
            ],
            'filter' => [
                'all' => 'All',
                'filter_label' => 'Filter',
                'filter_title' => 'Filter',
                'color_label' => 'Color',
                'feature_label' => 'Features',
                'reset' => 'Reset',
                'apply' => 'View products',
                'empty' => 'No products match this selection.',
                'empty_reset' => 'Clear filters',
                'count_suffix' => 'products',
                'size_60x280' => '60×280',
                'thick_8' => '8 mm',
                'depot' => 'In stock',
            ],
            'seo' => [
                'kicker' => 'Guide',
                'title' => 'Silva Arc Panel Collection',
                'more' => 'Read more',
                'body' => [
                    'The Silva Arc Panel Collection spans Wood, Metal, Root and Travertine series. Panels are produced at 60×280×8 mm. For samples and orders, reach the team via the Acarkon Store network.',
                    'Wood–polymer composite (WPC) brings metal, root wood, textile and natural wood textures indoors — a moisture-resistant, long-lasting cladding.',
                    'Wood Series covers oak and walnut panels; Metal Series champagne, inox, titanium and anthracite; Root Series root-veneer character; Travertine Series beige, ivory and terra textures.',
                    'For samples, quantity and installation, contact the Acarkon Store network or use the contact form.',
                ],
            ],
            'detail' => [
                'related_kicker' => 'Silva Arc Panel Collection',
                'related_title' => 'Similar panels',
                'related_from' => 'From the :cat collection',
                'spec_code' => 'Product code',
                'spec_collection' => 'Collection',
                'spec_color' => 'Color',
                'spec_size' => 'Size',
                'spec_thick' => 'Thickness',
                'spec_extra' => 'Custom order',
                'mm' => 'mm',
                'indoor' => 'Suitable for indoor use',
                'outdoor' => 'Suitable for outdoor use',
                'depot' => 'In stock',
                'add_cart' => 'Add to cart',
                'quote' => 'Get a quote',
                'qty' => 'Qty',
                'image_pending' => 'Product image coming soon',
                'collection_crumb' => 'Silva Arc Panel Collection',
            ],
        ];
    }
}
