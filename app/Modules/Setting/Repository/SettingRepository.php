<?php

namespace App\Modules\Setting\Repository;

use App\Modules\Setting\Entity\Mail;
use App\Modules\Setting\Entity\Notification;
use App\Modules\Setting\Entity\Office;
use App\Modules\Setting\Entity\Organization;
use App\Modules\Setting\Entity\Schedule;
use App\Modules\Setting\Entity\Web;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Setting\Entity\Setting;

class SettingRepository
{

    public function getIndex(Request $request): Arrayable
    {
        return Setting::orderBy('name')
            ->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Setting $setting) => [
                'id' => $setting->id,
                'name' => $setting->name,
                'slug' => $setting->slug,
                'class' => $setting->class,
                'description' => $setting->description,
                'url' => route('admin.setting.' . $setting->slug),
            ]);
    }

    public function getOrganization(): Organization
    {
        $setting = Setting::where('slug', 'organization')->first();
        return new Organization($setting->getData());
    }

    public function getOffice(): Office
    {
        $setting = Setting::where('slug', 'office')->first();
        return new Office($setting->getData());
    }

    public function getWeb(): Web
    {
        $setting = Setting::where('slug', 'web')->first();
        return new Web($setting->getData());
    }

    public function getNotification()
    {
        $notification = Setting::where('slug', 'notification')->first();
        return new Notification($notification->getData());
    }

    public function getMail(): Mail
    {
        $setting = Setting::where('slug', 'mail')->first();
        return new Mail($setting->getData());
    }

    public function getSchedule()
    {
        $setting = Setting::where('slug', 'schedule')->first();
        return new Schedule($setting->getData());
    }
}
