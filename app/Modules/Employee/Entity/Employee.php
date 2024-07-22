<?php
declare(strict_types=1);

namespace App\Modules\Employee\Entity;

use App\Modules\Base\Casts\FullNameCast;
use App\Modules\Base\Casts\GeoAddressCast;
use App\Modules\Base\Entity\FullName;
use App\Modules\Base\Entity\GeoAddress;
use App\Modules\Base\Entity\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $phone
 * @property string $password
 * @property bool $active //Не заблокирован
 * @property int $telegram_user_id
 * @property float $rating
 * @property FullName $fullname
 * @property GeoAddress $address
 * @property Photo $photo
 * @property Specialization[] $specializations
 */
class Employee extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;
    protected string $guard = 'employee';

    protected $fillable = [
        'password',
        'phone',
        'active',
        'telegram_user_id',
        'fullname',
        'address',
    ];
    protected $casts = [
        'password' => 'hashed',
        'fullname' => FullNameCast::class,
        'address' => GeoAddressCast::class
    ];

    public static function register(string $phone, string $password)
    {
        return static::create([
            'phone' => $phone,
            'password' => Hash::make($password),
            'active' => true,
            'fullname' => new FullName(),
            'address' => new GeoAddress(),
        ]);
    }


    public function photo()
    {
        return $this->morphOne(Photo::class, 'imageable');//->withDefault();
    }

}
