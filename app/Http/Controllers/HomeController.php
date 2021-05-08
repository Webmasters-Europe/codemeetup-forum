<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Config;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        phpinfo();
        $numberCategories = config('app.settings.number_categories_startpage');
        $category = Category::first();
        dd($category);
        $categories = Category::orderBy('name')->paginate($numberCategories);
        dd($categories);
        foreach ($categories as $category) {
            $category->latestPost = $category->latestPost();
        }

        //return view('welcome', compact('categories'));
    }
}
