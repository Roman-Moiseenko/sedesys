<?php

namespace App\Modules\Calendar\Repository;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Calendar\Entity\Calendar;

class CalendarRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {

        $query = Calendar::orderByDesc('record_at');
        /**
         * Фильтр, для каждого параметра своя проверка
         */
        $filters = [];
        if ($request->has('phone')) {
            $phone = $request->string('phone')->trim()->value();
            $filters['phone'] = $phone;
            $query->whereHas('user', function ($query) use ($phone) {
                $query->where('phone', $phone);
            });
        }

        if ($request->has('service')) {
            $service = $request->integer('service');
            $filters['service'] = $service;
            $query->where('service_id', $service);
        }
        if ($request->has('day_at')) {

            $day_at = Carbon::parse(date('Y-m-d H:i:s',strtotime(request('day_at'))));
            $day_begin = $day_at->toDateString();
            $day_end = (clone $day_at)->addDay()->toDateString();
            //dd([$day_at, $day_begin, $day_end, $request['day_at']]);
            $filters['day_at'] = $day_at;
            $query->where('record_at', '>=', $day_begin)->where('record_at', '<', $day_end);
        }
        if ($request->has('employee')) {
            $employee = $request->integer('employee');
            $filters['employee'] = $employee;
            $query->where('employee_id', $employee);
        }

        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Calendar $calendar) => $this->CalendarToArray($calendar));
    }


    public function CalendarToArray(Calendar $calendar): array
    {
        return [
            'id' => $calendar->id,
            'day_at' => $calendar->record_at->translatedFormat('d-M-Y'),
            'time_at' => $calendar->record_at->translatedFormat('H:i'),
            'service' => $calendar->service->name,
            'employee' => $calendar->employee->fullname->getFullName(),
            'user' => $calendar->user->phone . ' (' . $calendar->user->fullname->firstname .' )',
            'comment' => $calendar->comment,
            'order_id' => $calendar->order_id,
            'today' => $this->isToday($calendar->record_at),
            'is_cancel' =>$calendar->isCancel(),
            'status' => $calendar->status(),
            'to_order' => route('admin.calendar.calendar.to-order', $calendar),
            'cancel' => route('admin.calendar.calendar.cancel', $calendar),
            'destroy' => route('admin.calendar.calendar.destroy', $calendar),
        ];
    }


    private function isToday(Carbon $date): int
    {
        $now = Carbon::parse(now()->toDateString());
        $_date = Carbon::parse($date->toDateString());

        if ($now->eq($_date)) return 0;
        if ($now->lt($_date)) return 1;
        if ($now->gt($_date)) return -1;
        throw new \DomainException('Неверная дата ' . $date->format('d-m-Y'));
    }
}
