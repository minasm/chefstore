<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        dd($request->all());
        $term = trim((string) $request->input('term', ''));

        $results = $term === ''
            ? []
            : \App\Models\Faq::query()
                ->where('question', 'like', "%{$term}%")
                ->limit(10)
                ->get(['id','category_id','question','answer']);

        // Render the SAME page component you're on (e.g. Home/Index)
        // and include/override a `searchResults` prop.
        return Inertia::render('Home/Index', [
            'searchResults' => $results,
            // ...other page props as usual
        ]);
    }
}
