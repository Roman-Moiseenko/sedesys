<?php

namespace App\Modules\Setting\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Setting\Repository\SettingRepository;
use App\Modules\Setting\Service\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{

    private SettingService $service;
    private SettingRepository $repository;

    public function __construct(SettingService $service, SettingRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }


    public function index(Request $request)
    {
        $settings = $this->repository->getIndex($request);
        return Inertia::render('Setting/Index', [
                'settings' => $settings,
            ]
        );
    }

    //Сведения об Организации
    public function organization()
    {
        $organization = $this->repository->getOrganization();
        return Inertia::render('Setting/Organization', [
                'organization' => $organization,
                'route' => route('admin.setting.update'),
            ]
        );
    }

    //Офис
    public function office()
    {
        $office = $this->repository->getOffice();
        return Inertia::render('Setting/Office', [
                'office' => $office,
                'route' => route('admin.setting.update'),
            ]
        );
    }

    //Настройки веб-сайта
    public function web()
    {
        $models = $this->repository->displayedModels();

        $web = $this->repository->getWeb();
        return Inertia::render('Setting/Web', [
                'web' => $web,
                'route' => route('admin.setting.update'),
                'models' => $models,
            ]
        );
    }

    //Настройки Уведомлений
    public function notification()
    {
        $notification = $this->repository->getNotification();
        return Inertia::render('Setting/Notification', [
                'notification' => $notification,
                'route' => route('admin.setting.update'),
            ]
        );
    }

    //Настройки почты
    public function mail(): Response
    {
        $mail = $this->repository->getMail();
        return Inertia::render('Setting/Mail', [
                'mail' => $mail,
                'route' => route('admin.setting.update'),
            ]
        );
    }

    //Настройки расписания и график работы
    public function schedule(): Response
    {
        $schedule = $this->repository->getSchedule();
        return Inertia::render('Setting/Schedule', [
                'schedule' => $schedule,
                'route' => route('admin.setting.update'),
            ]
        );
    }

    //Настройки расписания и график работы
    public function discount(): Response
    {
        $discount = $this->repository->getDiscount();
        return Inertia::render('Setting/Discount', [
                'discount' => $discount,
                'route' => route('admin.setting.update'),
            ]
        );
    }

    public function update(Request $request): RedirectResponse
    {
        $this->service->update($request);
        return redirect()->back()->with('success', 'Сохранение прошло успешно');
    }
}
