<?php
declare(strict_types=1);

namespace App\Modules\Admin\Entity;


use App\Modules\Base\Casts\FullNameCast;
use App\Modules\Base\Entity\FullName;
use App\Modules\Base\Entity\Photo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ExpectedValues;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name //Логин
// * @property string $email //Для защищенной аутентификации - простой способ
 * @property string $phone //  - сложный способ
 * @property string $password
 * @property string $role
 * @property bool $active //Не заблокирован
 * @property string $post //Должность
 * @property int $telegram_user_id
 * @property string $attr_full_name
 * @property FullName $fullname
 * @property Responsibility[] $responsibilities
 * @property Photo $photo
 */
class Admin extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_STAFF = 'staff'; //Все сотрудники
    public const ROLE_CHIEF = 'chief'; //Руководитель - назначение сотрудников, смена обязанностей
    public const ROLE_ADMIN = 'admin'; //Администратор - учет, логи и др.


    public const ROLES = [
        self::ROLE_ADMIN => 'Администратор',
        self::ROLE_CHIEF => 'Руководитель',
        self::ROLE_STAFF => 'Сотрудник',
    ];

    public const ROLE_COLORS = [
        self::ROLE_ADMIN => 'bg-danger',
        self::ROLE_CHIEF => 'bg-success',
        self::ROLE_STAFF => 'bg-primary',
    ];

    protected string $guard = 'admin';

    protected $fillable = [
        'id',
        'name',
        'password',
        'phone',
        'role',
        'active',
        'post',
        'telegram_user_id',
        'fullname',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'fullname' => FullNameCast::class
    ];

    public static function register(string $name, string $phone, string $password): self
    {
        return static::create([
            'name' => $name,
            'phone' => $phone,
            'password' => Hash::make($password),
            'role' => self::ROLE_STAFF,
            'active' => true,
            'fullname' => new FullName(),
        ]);
    }

    public static function new(string $name, string $email, string $phone, string $password): self
    {
        return static::make([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make($password),
            'role' => self::ROLE_STAFF,
            'active' => true,
        ]);
    }

    public function blocked(): void
    {
        $this->active = false;
    }

    public function isBlocked(): bool
    {
        return !$this->active;
    }

//Роли
    public function isAdmin(): bool
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function isChief(): bool
    {
        return $this->role == self::ROLE_CHIEF;
    }


    public function isStaff(): bool
    {
        return $this->role == self::ROLE_STAFF;
    }

    public function setRole($role): void
    {
        if (!array_key_exists($role, self::ROLES)) {
            throw new \InvalidArgumentException('Неверная роль пользователя ' . $role);
        }
        $this->role = $role;
        $this->save();
    }

    public function setChatID(string $chatID)
    {
        $this->telegram_user_id = $chatID;
        $this->save();
    }

    public function setFullName(FullName $fullname): void
    {
        $this->fullname = $fullname;
    }

    public function activated()
    {
        $this->active = true;
    }

    public function isCurrent(): bool
    {
        return Auth::guard($this->guard)->user()->id == $this->id;
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'imageable');//->withDefault();
    }


    public function getPhoto(): string
    {
        if (empty($this->photo->file)) {
            return '/images/default-user.png';
        } else {
            return $this->photo->getUploadUrl();
        }
    }
    /*
        public function setPhoto(string $file): void
        {
            $this->photo = $file;
        }
    */
    public function routeNotificationForTelegram(): int
    {
        return $this->telegram_user_id;
    }

    public function isResponsibility(#[ExpectedValues(valuesFromClass: Responsibility::class)] int $resp): bool
    {
        if (!$this->isStaff()) return false;
        foreach ($this->responsibilities as $responsibility) {
            if ($responsibility->code == $resp) return true;
        }
        return false;
    }

    public function responsibilities()
    {
        return $this->hasMany(Responsibility::class, 'admin_id', 'id');
    }

    public function toggleResponsibilities(int $code)
    {
        foreach ($this->responsibilities as $responsibility) { //Если Обязанность уже назначена, то удаляем
            if ($responsibility->code == $code) {
                $responsibility->delete();
                return;
            }
        }
        //Иначе добавляем Обязанность
        $this->responsibilities()->save(Responsibility::new($code));
    }
    public function roleHTML(): string
    {
        return self::ROLES[$this->role];
    }

    protected function attrFullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->fullname->getFullName(),
        );
    }

}
