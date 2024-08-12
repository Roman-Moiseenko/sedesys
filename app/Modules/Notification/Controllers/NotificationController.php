<?php

namespace App\Modules\Notification\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Entity\Admin;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Notification\Entity\Notification;
use App\Modules\Notification\Requests\NotificationRequest;
use App\Modules\Notification\Repository\NotificationRepository;
use App\Modules\Notification\Service\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use JetBrains\PhpStorm\Deprecated;

class NotificationController extends Controller
{

    private NotificationService $service;
    private NotificationRepository $repository;

    public function __construct(NotificationService $service, NotificationRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();
        $notifications = $this->repository->getIndex($request);

        return Inertia::render('Notification/Notification/Index', [
                'notifications' => $notifications,
                'chief' => $admin->isAdmin() || $admin->isChief(),
            ]
        );
    }

    public function read(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return redirect()->back();
    }

    public function create(Request $request)
    {
        $staffs = Admin::where('active', true)->get()->map(function (Admin $staff) {
            return [
                'id' => $staff->id,
                'telegram_id' => $staff->telegram_user_id,
                'name' => $staff->fullname->getFullName(),
            ];
        })->toArray();
        $employees = Employee::where('active', true)->get()->map(function (Employee $employee) {
            return [
                'id' => $employee->id,
                'telegram_id' => $employee->telegram_user_id,
                'name' => $employee->fullname->getFullName(),
            ];
        })->toArray();
        return Inertia::render('Notification/Notification/Create', [
            'route' => route('admin.notification.notification.store'),
            'staffs' => $staffs,
            'employees' => $employees,
        ]);
    }

    public function store(NotificationRequest $request)
    {
        $request->validated();
        $this->service->create($request);
        return redirect()
            ->route('admin.notification.notification.index')
            ->with('success', 'Уведомление отправлено');
    }


    #[Deprecated]
    public function show(Notification $notification)
    {
        return Inertia::render('Notification/Notification/Show', [
                'notification' => $notification,
                'edit' => route('admin.notification.notification.edit', $notification),
            ]
        );
    }

    #[Deprecated]
    public function edit(Notification $notification)
    {
        return Inertia::render('Notification/Notification/Edit', [
            'notification' => $notification,
            'route' => route('admin.notification.notification.update', $notification),
        ]);
    }

    #[Deprecated]
    public function update(NotificationRequest $request, Notification $notification)
    {
        $request->validated();
        $this->service->update($notification, $request);
        return redirect()
            ->route('admin.notification.notification.show', $notification)
            ->with('success', 'Сохранение прошло успешно');
    }

    #[Deprecated]
    public function destroy(Notification $notification)
    {
        $this->service->destroy($notification);
        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }


}
