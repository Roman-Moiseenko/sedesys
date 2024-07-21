<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Entity\User;
use App\Modules\User\Requests\UserRequest;
use App\Modules\User\Repository\UserRepository;
use App\Modules\User\Service\UserService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        $users = $this->repository->getIndex($request);

        return Inertia::render('User/User/Index', [
                'users' => $users,
            ]
        );
    }

    public function create(Request $request)
    {
        return Inertia::render('User/User/Create', []);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $user = $this->service->create($request);
        return redirect()
            ->route('admin.user.user.show', $user)
            ->with('success', 'Новый user добавлен');;
    }

    public function show(User $user)
    {
        return Inertia::render('User/User/Show', [
                'user' => $user
            ]
        );
    }

    public function edit(User $user)
    {
        return Inertia::render('User/User/Edit', [
            'user' => $user
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $user = $this->service->update($user, $request);
        return redirect()
            ->route('admin.user.user.show', $user)
            ->with('success', 'Сохранение прошло успешно');;
    }

    public function destroy(User $user)
    {
        $this->service->destroy($user);

        return redirect()->back()->with('success', 'Удаление прошло успешно');;
    }
}
