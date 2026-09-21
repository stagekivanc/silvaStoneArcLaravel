<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SilvaHomepageSeeder::class,
            SilvaContactSeeder::class,
            SilvaDealerSeeder::class,
            SilvaLegalPagesSeeder::class,
            SilvaContractsSeeder::class,
            SilvaStoresSeeder::class,
            SilvaProjectsSeeder::class,
            ArcCatalogSeeder::class,
            SilvaArcHomepageSeeder::class,
            SilvaEnglishContentSeeder::class,
        ]);
    }
}
