<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        $categories = Category::orderBy('name')->paginate(10);

        foreach($categories as $category) {
            $category->latestPost = $category->latestPost();
        }

        return view('welcome', compact('categories'));
    }
}
