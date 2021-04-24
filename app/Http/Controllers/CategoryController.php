<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     */
    public function __invoke(Category $category)
    {
        $this->authorize('view', Category::class);

        $posts = $category->posts()->orderBy('created_at', 'desc')->with('user')->paginate(10);

        return view('categories.show', compact('category', 'posts'));
    }
}
