<?php
declare(strict_types=1);

namespace App\Modules\Calendar\Service;

use App\Modules\Calendar\Entity\Calendar;
use App\Modules\Calendar\Entity\Regularity;
use App\Modules\Calendar\Entity\Rule;
use App\Modules\Service\Entity\Service;
use App\Modules\Setting\Entity\Schedule;
use App\Modules\Setting\Repository\SettingRepository;
use Carbon\Carbon;

class Calculate
{
    private Schedule $schedule;

    public function __construct()
    {
        $settings = new SettingRepository();
        $this->schedule = $settings->getSchedule();
    }

    public function rule(Carbon $date, int $service_id): array
    {
        if ($date->lt(Carbon::parse(now()->toDateString()))) return [];
        //Начало и конец рабочего дня
        $begin = Carbon::parse($date->format('Y-m-d') . ' ' . $this->schedule->begin_work);
        $end = Carbon::parse($date->format('Y-m-d') . ' ' . $this->schedule->end_work);

        $current_service = Service::find($service_id);
        $result = [];

        $rules = Rule::active()->whereHas('services', function ($query) use ($service_id) {
            $query->where('id', $service_id);
        })->get();

        /** @var Rule $rule */
        foreach ($rules as $rule) {
            if ($this->checkDate($date, $rule->regularity)) {
                foreach ($rule->employees as $employee) {
                    $records = []; //Записи на текущий день к мастеру $employee
                    //Для каждой услуги обработать календарь
                    foreach ($rule->services as $service) {
                        $calendars = Calendar::where('record_at', '>=', $begin)
                            ->where('record_at', '<=', $end)
                            ->where('service_id', $service->id)
                            ->where('employee_id', $employee->id)->get();
                        /** @var Calendar $calendar */
                        foreach ($calendars as $calendar) {
                            $records[] = [
                                'begin' => $calendar->record_at,
                                'end' => $calendar->record_at->addMinutes($service->duration),
                            ];
                        }
                    }
                    $_begin = clone $begin;
                    $_end = clone $end;
                    $result[$employee->id] = [
                        'id' => $employee->id,
                        'fullname' => $employee->fullname->getFullName(),
                        'times' => $this->getFreeTime($records, $_begin, $_end, $current_service->duration),
                    ];
                }
                return $result;
            }
        }
        return [];
    }

    private function checkDate(Carbon $date, int $regularity): bool
    {
        return match ($regularity) {
            Regularity::EVERYDAY => true,
            Regularity::WEEK_MON => $date->dayOfWeekIso == 1,
            Regularity::WEEK_TUE => $date->dayOfWeekIso == 2,
            Regularity::WEEK_WED => $date->dayOfWeekIso == 3,
            Regularity::WEEK_THU => $date->dayOfWeekIso == 4,
            Regularity::WEEK_FRI => $date->dayOfWeekIso == 5,
            Regularity::WEEK_SAT => $date->dayOfWeekIso == 6,
            Regularity::WEEK_SUN => $date->dayOfWeekIso == 7,
            Regularity::WEEK_WEEKDAY => $date->dayOfWeekIso < 6,
            Regularity::WEEK_PART_TIME => $date->dayOfWeekIso < 5,
            Regularity::WEEK_WEEKENDS => $date->dayOfWeekIso > 5,
            Regularity::X1_FIRST => abs($date->diffInDays($this->schedule->begin_x_date)) % 2 == 0,
            Regularity::X1_SECOND => abs($date->diffInDays($this->schedule->begin_x_date)) % 2 == 1,
            Regularity::X2_FIRST => abs($date->diffInDays($this->schedule->begin_x_date)) % 4 <= 1,
            Regularity::X2_SECOND => abs($date->diffInDays($this->schedule->begin_x_date)) % 4 >= 2,

        };
    }

    private function getFreeTime(array $records, Carbon $begin, Carbon $end, int $duration): array
    {
        $result = [];

        if (empty($records)) {
            return $this->freeRange($begin, $end, $duration);
        }

        $line[] = $begin;
        foreach ($records as $record) {
            $line[] = $record['begin'];
            $line[] = $record['end'];
        }
        $line[] = $end;

        $count = count($line);
        for ($i = 0; $i < $count; $i = $i + 2) {
            $result = array_merge(
                $result,
                $this->freeRange($line[$i], $line[$i + 1], $duration)
            );
        }
        return $result;
    }

    private function freeRange(Carbon $begin, Carbon $end, int $duration): array
    {
        $result = [];
        $end->subMinutes($duration);

        while ($begin->lte($end)) {
            $result[] = $begin->format('H:i');
            $begin->addMinutes($duration);
        }
        return $result;
    }
}
