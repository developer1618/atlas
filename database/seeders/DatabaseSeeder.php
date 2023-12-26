<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->prepareRun();

        $this->call([
            LanguageSeeder::class,
            BlogSeeder::class,
            CurrencySeeder::class,
            AmenitySeeder::class,
            FoodTypeSeeder::class,
            RoomCategorySeeder::class,
            RoomSeeder::class,
            FoodTypeSeeder::class,
            FoodSeeder::class,
            FeatureSeeder::class,
            ServiceSeeder::class,
            CustomerSeeder::class,
            PlaceSeeder::class,
            TaxSeeder::class,
            PageSeeder::class,
            TestimonialSeeder::class,
            GallerySeeder::class,
            UserSeeder::class,
            UserMetaSeeder::class,
            SettingSeeder::class,
            ThemeOptionSeeder::class,
            WidgetSeeder::class,
            SimpleSliderSeeder::class,
            FaqSeeder::class,
            TeamSeeder::class,
            MenuSeeder::class,
            BookingSeeder::class,
            ReviewSeeder::class,
        ]);

        $this->finished();
    }
}
