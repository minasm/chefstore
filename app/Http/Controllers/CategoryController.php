<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategorySimpleResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::with('faqs')->paginate(10);
        return Inertia::render('Welcome')->with('categories', $categories);
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category, Request $request)
    {
        $faqs = $category->faqs()->paginate(10);

        $category->setRelation('faqs', $faqs);


        return Inertia::render('Category')->with([
            'categories' => CategorySimpleResource::collection(Category::get()),
            'category' => $category,
            'highlightId' => $request->integer('highlight') ?: null,
             'page' => $request->integer('page') ?: 1, // if you need it
        ]);
    }
}
