<?php
declare(strict_types=1);

namespace App\Modules\Employee\Entity;

use App\Modules\Base\Casts\FullNameCast;
use App\Modules\Base\Casts\GeoAddressCast;
use App\Modules\Base\Entity\FullName;
use App\Modules\Base\Entity\GeoAddress;
use App\Modules\Base\Entity\Photo;
use App\Modules\Page\Entity\WidgetData;
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
class Employee extends Authenticatable implements WidgetData
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


    public function isBlocked(): bool
    {
        return $this->active == false;
    }

    public function activated()
    {
        $this->active = true;
        $this->save();
    }

    public function blocked()
    {
        $this->active = false;
        $this->save();
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'imageable');//->withDefault();
    }

    public function getImage(): ?string
    {
        if (is_null($this->photo)) return null;
        return $this->photo->getThumbUrl('card');
    }

    public function getUrl(): string
    {
        return route('web.employee.view', $this);
    }

    public function getCaption(): string
    {
        return $this->fullname->getFullName();
    }

    public function getText(): string
    {
        return '';
    }
}
