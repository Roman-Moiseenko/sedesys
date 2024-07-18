<?php

namespace App\Modules\Employee\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Employee\Entity\Operating;

class OperatingService
{
    //TODO Внести методы и объект
    public function create(Request $request): Operating
    {
        $operating = Operating::register();


        return  $operating;
    }

    public function update(Operating $operating, Request $request)
    {

    }

    public function delete(Operating $operating)
    {
        $operating->delete();
    }
}
