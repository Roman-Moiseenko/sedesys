<?php

namespace App\Modules\Setting\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $data
 * @property string $class
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Setting extends Model
{
    use HasFactory;

    protected $attributes = [
        'data' => '{}',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'data' => 'json',
    ];
    protected $fillable = [
        'name',
        'slug',
        'class',
        'description',
    ];


    public function setData($object): void
    {
        $this->data = json_encode($object);
        $this->save();
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}
