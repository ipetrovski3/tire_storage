<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            'tires' => ['Michelin', 'Continental', 'Dunlop', 'Pirelli', 'Sava', 'Tigar', 'Sailun', 'Goodyear', 'Cooper', 'Kelly', 'Star Fire', 'Nankang'],
            'oil' => ['Aral', 'Reinol', 'Castrol']
        ];

        foreach ($brands as $key => $brand) {
            $type = $key == 'tires' ? Category::find(1) : Category::find(2);
            foreach ($brand as $name) {
                $brand = new Brand;
                $brand->name = $name;
                $brand->category_id = $type->id;
                $brand->save();
            }
        }

        User::create(['email' => 'ipetrovski3@gmail.com', 'name' => 'Igor', 'password' => bcrypt('ipetrovski3@gmail.com')]);
    }
}
