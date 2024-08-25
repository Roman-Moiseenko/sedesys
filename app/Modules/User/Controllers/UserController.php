<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Entity\User;
use App\Modules\User\Requests\UserRequest;
use App\Modules\User\Repository\UserRepository;
use App\Modules\User\Service\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{

    private UserService $service;
    private UserRepository $repository;

    public function __construct(UserService $service, UserRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $users = $this->repository->getIndex($request, $filters);

        return Inertia::render('User/User/Index', [
                'users' => $users,
                'filters' => $filters,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('User/User/Create', [
            'route' => route('admin.user.user.store'),
        ]);
    }

    public function store(UserRequest $request)
    {
        $request->validated();
        $user = $this->service->create($request);
        return redirect()
            ->route('admin.user.user.show', $user)
            ->with('success', 'Новый клиент добавлен');
    }

    public function show(User $user)
    {
        return Inertia::render('User/User/Show', [
                'user' => $user,
                'edit' => route('admin.user.user.edit', $user),
            ]
        );
    }

    public function edit(User $user)
    {
        return Inertia::render('User/User/Edit', [
            'user' => $user,
            'route' => route('admin.user.user.update', $user),
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $request->validated();
        $this->service->update($user, $request);
        return redirect()
            ->route('admin.user.user.show', $user)
            ->with('success', 'Сохранение прошло успешно');
    }

    public function destroy(User $user)
    {
        $this->service->destroy($user);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function verify(User $user)
    {
        $user->verify();
        return redirect()->back()->with('success', 'Пользователь верифицирован');
    }
}
