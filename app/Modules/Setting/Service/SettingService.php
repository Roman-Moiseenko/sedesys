<?php

namespace App\Modules\Setting\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Setting\Entity\Setting;

class SettingService
{


    public function update(Request $request)
    {
        /** @var Setting $setting */
        $setting = Setting::where('slug', $request->string('slug')->value())->first();

        $data = $request->except(['slug']);
        $setting->data = $data;

        $setting->save();

    }

}
