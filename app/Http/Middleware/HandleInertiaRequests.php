<?php

namespace App\Http\Middleware;

use App\Modules\Base\Helpers\AdminMenu;
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
       // $data = \Diglactic\Breadcrumbs\Breadcrumbs::view('breadcrumbs::json-ld')->getData()['breadcrumbs'];

        return array_merge(parent::share($request), [
            'auth' => function () use ($request) {
                return [
                    'user' => $request->user() ? [
                        'id' => $request->user()->id,
                        'first_name' => $request->user()->fullname->firstname,
                        'last_name' => $request->user()->fullname->surname,
                        'phone' => $request->user()->phone,
                        'post' => $request->user()->post,
                        'account' => [
                            'id' => $request->user()->id,
                            'name' => $request->user()->name,
                        ],
                    ] : null,
                ];
            },
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
            'menus' => function () use ($request) {
                return AdminMenu::menu();
            },
            'breadcrumbs' => function () use($request) {
                if ($request->path() == 'admin/login') return '';
                return \Diglactic\Breadcrumbs\Breadcrumbs::view('breadcrumbs::json-ld')->getData()['breadcrumbs'];
            },
        ]);
    }
}
