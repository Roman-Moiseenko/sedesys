<?php

namespace App\Modules\Calendar\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Calendar\Entity\Calendar;
use App\Modules\Calendar\Requests\CalendarRequest;
use App\Modules\Calendar\Repository\CalendarRepository;
use App\Modules\Calendar\Service\Calculate;
use App\Modules\Calendar\Service\CalendarService;
use App\Modules\Employee\Entity\Employee;
use App\Modules\Employee\Repository\EmployeeRepository;
use App\Modules\Service\Entity\Service;
use App\Modules\Service\Repository\ServiceRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarController extends Controller
{

    private CalendarService $service;
    private CalendarRepository $repository;
    private ServiceRepository $services;
    private Calculate $calculate;
    private EmployeeRepository $employees;

    public function __construct(
        CalendarService    $service,
        CalendarRepository $repository,
        ServiceRepository  $services,
        Calculate          $calculate,
        EmployeeRepository $employees
    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->services = $services;
        $this->calculate = $calculate;
        $this->employees = $employees;
    }

    public function index(Request $request)
    {
        $calendars = $this->repository->getIndex($request, $filters);
        $services = $this->services->getActive();
        $employees = $this->employees->getActive();

        return Inertia::render('Calendar/Calendar/Index', [
                'calendars' => $calendars,
                'filters' => $filters,
                'services' => $services,
                'employees' => $employees,
            ]
        );
    }

    public function create(Request $request)
    {
        $services = $this->services->getActive();
        if ($request->has('mode')) {
            $mode = $request->string('mode');
            if ($mode == 'get') {
                $date = $request->date('date');
                $service_id = $request->integer('service_id');
                $rules = $this->calculate->rule($date, $service_id);
                $service = Service::find($service_id);
                $info = [
                    'service' => $service->name,
                    'date' => (Carbon::parse($date))->translatedFormat('j F Y'),
                ];
            }
            if ($mode == 'save') {
                $this->service->create($request);
                return redirect()->route('admin.calendar.calendar.index')
                    ->with('success', 'Новая запись добавлена');
            }
        }

        return Inertia::render('Calendar/Calendar/Create', [
            'services' => $services,
            'rules' => $rules ?? [],
            'info' => $info ?? null,
        ]);
    }

    public function destroy(Calendar $calendar)
    {
        $this->service->destroy($calendar);

        return redirect()->back()->with('success', 'Запись удалена');
    }

    public function to_order(Calendar $calendar)
    {
        $order = $this->service->createOrder($calendar);
        return redirect()->route('admin.order.order.show', $order);
    }

    public function cancel(Calendar $calendar)
    {
        $calendar->cancel();
        return redirect()->back()->with('success', 'Запись отменена');
    }

}
