<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\pattern;
use App\Models\Product;
use App\Models\Season;
use App\Queries\TireQuery;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show($id, TireQuery $tireQuery)
    {
        $category = Category::find($id);
        $brands = Brand::where('category_id', $category->id)->get();
        $patterns = Pattern::all();

        if ($category->name == 'Гуми') {
            $summer = $tireQuery->set_season(1);
            $winter = $tireQuery->set_season(2);
            $all_season = $tireQuery->set_season(3);
        }

        return view('dashboard.categories.show')->with([
            'category' => $category,
            'summer' => $summer ?? 'undefined',
            'winter' => $winter ?? 'undefined',
            'all_season' => $all_season ?? 'undefined',
            'brands' => $brands,
            'patterns' => $patterns
        ]);
    }

    public function get_patterns(Request $request)
    {
        $patterns = Pattern::where('brand_id', $request->brand_id)->get();

        return view('dashboard.categories.partials.patterns')->with(['patterns' => $patterns])->render();
    }
}
