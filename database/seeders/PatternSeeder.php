<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Pattern;
use App\Models\Season;
use Illuminate\Database\Seeder;

class PatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $summer = Season::where('name', 'Summer')->first()->id;
        $winter = Season::where('name', 'Winter')->first()->id;

        $all_season = Season::where('name', 'All Season')->first()->id;

        $michelin = Brand::where('name', 'Michelin')->first()->id;
        $michelin_summer = ['Pilot Sport 3', 'Pilot Sport 4', 'Primacy 4', 'Energy Saver'];
        $michelin_winter = ['Alpin A5', 'Alpin A6', 'Pilot Aplin PA5'];
        $michelin_all_season = ['CrossClimate'];

        $sava = Brand::where('name', 'Sava')->first()->id;
        $sava_summer = ['Perfecta', 'Intensa HP', 'Intensa HP2', 'Intensa UHP', 'Intensa UHP2'];
        $sava_winter = ['Eskimo S3+', 'Eskimo HP', 'Eskimo HP2'];
        $sava_all_season = ['Adapto', 'Adapto HP', 'All Weather'];

        $tyre = Category::first()->id;
        $this->make_pattern($summer, $michelin_summer, $michelin, $tyre);
        $this->make_pattern($winter, $michelin_winter, $michelin, $tyre);
        $this->make_pattern($all_season, $michelin_all_season, $michelin, $tyre);

        $this->make_pattern($summer, $sava_summer, $sava, $tyre);
        $this->make_pattern($winter, $sava_winter, $sava, $tyre);
        $this->make_pattern($all_season, $sava_all_season, $sava, $tyre);


    }

    private function make_pattern($season, $pattern_type, $brand, $category)
    {
        foreach ($pattern_type as $value) {
            $pattern = new Pattern;
            $pattern->name = $value;
            $pattern->brand_id = $brand;
            $pattern->season_id = $season;
            $pattern->category_id = $category;
            $pattern->save();
        }
    }
}
