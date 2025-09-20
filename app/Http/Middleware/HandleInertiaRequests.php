<?php

namespace App\Http\Middleware;

use App\Models\Faq;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Inertia;
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

        return [
            ...parent::share($request),

            'searchResults' => Inertia::optional(function () use ($request) {
                $term = trim((string) $request->input('term', ''));
                if ($term === '') return [];

                $perPage = (int) config('faq.per_page', 10);
                $order = strtolower((string) config('faq.order', 'asc'));

                // Fetch minimal fields + category slug, searching both question & answer, distinct FAQs
                $hits = Faq::query()
                    ->with('category:id,slug')
                    ->select(['id', 'category_id', 'question', 'answer'])
                    ->where(function ($q) use ($term) {
                        $q->where('question', 'like', "%{$term}%")
                          ->orWhere('answer', 'like', "%{$term}%");
                    })
                    ->distinct()
                    ->limit(10)
                    ->get();

                // Compute page per hit using configured order
                return $hits->map(function (Faq $faq) use ($perPage, $order) {
                    if ($order === 'desc') {
                        $beforeCount = Faq::query()
                            ->where('category_id', $faq->category_id)
                            ->where('id', '>', $faq->id)
                            ->count();
                    } else {
                        $beforeCount = Faq::query()
                            ->where('category_id', $faq->category_id)
                            ->where('id', '<', $faq->id)
                            ->count();
                    }
                    $position = $beforeCount + 1;
                    $page = (int) (floor(($position - 1) / max(1, (int) $perPage)) + 1);
                    return [
                        'id'            => $faq->id,
                        'category_id'   => $faq->category_id,
                        'category_slug' => optional($faq->category)->slug,
                        'question'      => $faq->question,
                        'answer'        => $faq->answer,
                        'page'          => $page,
                    ];
                });
            }),
        ];
    }
}
