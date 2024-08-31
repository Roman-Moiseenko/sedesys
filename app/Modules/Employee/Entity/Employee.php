<?php
declare(strict_types=1);

namespace App\Modules\Employee\Entity;

use App\Modules\Base\Casts\FullNameCast;
use App\Modules\Base\Casts\GeoAddressCast;
use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Base\Entity\FullName;
use App\Modules\Base\Entity\GeoAddress;
use App\Modules\Base\Entity\Photo;
use App\Modules\Page\Entity\WidgetData;
use App\Modules\Service\Entity\Example;
use App\Modules\Service\Entity\Review;
use App\Modules\Service\Entity\Service;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $phone
 * @property string $password
 * @property bool $active //Не заблокирован
 * @property int $telegram_user_id
 * @property float $rating
 * @property int $experience_year
 * @property FullName $fullname
 * @property GeoAddress $address
 * @property Photo $photo
 * @property Specialization[] $specializations
 * @property Service[] $services
 * @property Example[] $examples
 * @property Review[] $reviews
 */
class Employee extends DisplayedModel implements
    WidgetData,
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{

    use HasApiTokens, HasFactory, Notifiable, \Illuminate\Auth\Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

    protected string $guard = 'employee';

    public $attributes = [
        'phone' => '',
        'address' => '{}',
    ];
    /*
    protected $fillable = [
        'password',
        'phone',
        'telegram_user_id',
        'fullname',
        'address',
    ];*/
    protected $casts = [
        'password' => 'hashed',
        'fullname' => FullNameCast::class,
        'address' => GeoAddressCast::class
    ];

    public static function register(string $name, string $slug = ''): self
    {
        throw new \DomainException('Нельзя вызывать для этого класса');
    }


    public static function employee(string $surname, string $firstname, string $secondname): self
    {
        /** @var Employee $employee */
        $employee = self::make([]);
        $employee->fullname = new FullName($surname, $firstname, $secondname);
        $employee->slug = Str::slug($employee->fullname->getFullName());
        $employee->password = Hash::make(Str::random());
        $employee->meta->h1 = $employee->fullname->getFullName();
        $employee->meta->title = $employee->fullname->getFullName();
        $employee->save();
        return $employee;
    }


    //TODO расчет годов/лет от текущей даты
    /*

        public function getExperience()
        {
            return is_null($this->experience_year) ? '' : (now()->year - $this->experience_year)
        }*/
    //RELATIONS

    public function examples()
    {
        return $this->belongsToMany(Example::class, 'employees_examples', 'employee_id', 'example_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'employees_services', 'employee_id', 'service_id')->withPivot(['extra_cost']);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'employee_id', 'id');
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'employees_specializations', 'employee_id', 'specialization_id')
            ->withPivot(['sort']);
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

    public function getCacheKeys(): array
    {
        $result = [
            'employees',
            'employee-' . $this->id
        ];
        foreach ($this->specializations as $specialization) {
            $result[] = 'specialization-' . $specialization->id;
        }
        return $result;
    }
}
