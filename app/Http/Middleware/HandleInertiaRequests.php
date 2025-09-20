<?php

namespace App\Http\Middleware;

use App\Models\Faq;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
            ],
            'searchResults' => \Inertia\Inertia::lazy(function () use ($request) {
                $term = trim((string) $request->input('term', ''));
                if ($term === '') return [];
                return Faq::query()
                    ->with('category:id,slug')
                    ->where('question', 'like', "%{$term}%")
                    ->limit(10)
                    ->get()
                    ->map(fn ($faq) => [
                        'id' => $faq->id,
                        'category_id' => $faq->category_id,
                        'category_slug' => optional($faq->category)->slug, // <- add this
                        'question' => $faq->question,
                        'answer' => $faq->answer,
                        'page' => $faq->page ?? null, // include if you have it
                    ]);
            }),
        ];
    }
}
