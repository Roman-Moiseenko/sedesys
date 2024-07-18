<?php

namespace App\Modules\Employee\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    const COLUMN_ID = 'id';
    const COLUMN_NAME = 'name';

    protected $guarded = [self::COLUMN_ID];
}
