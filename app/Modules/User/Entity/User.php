<?php

namespace App\Modules\User\Entity;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Modules\Base\Casts\FullNameCast;
use App\Modules\Base\Casts\GeoAddressCast;
use App\Modules\Base\Entity\FullName;
use App\Modules\Base\Entity\GeoAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $status
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $verify_token
 * @property int $client
 * @property bool $legal
 * @property FullName $fullname
 * @property GeoAddress $address

 *
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected string $guard = 'user';
    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';

    protected $fillable = [
        'email',
        'phone',
        'password',
        'status',
        'verify_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verify_token',
    ];

    protected $attributes = [
        'fullname' => '{}',
        'address' => '{}',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'fullname' => FullNameCast::class,
        'address' => GeoAddressCast::class
    ];

    public static function register(string $email, string $password): self
    {
        return static::create([
            'email' => $email,
            //'phone' => $phone,
            'password' => Hash::make($password),
            'verify_token' => rand(1234, 9876), //Str::uuid(),
            'status' => self::STATUS_WAIT,
        ]);
    }

    public static function new(string $email, string $phone): self
    {
        return static::create([
            'email' => $email,
            'phone' => $phone,
            'password' => bcrypt(Str::random()),
            'status' => self::STATUS_ACTIVE,
        ]);
    }


    //*** IS-...
    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    //*** SET-.....

    public function setPassword(string $password)
    {
        $this->password = Hash::make($password);
        $this->save();
    }

    public function verify()
    {
        if (!$this->isWait()) {
            throw new \DomainException('User is already verified.');
        }
        $this->update([
            'status' => self::STATUS_ACTIVE,
            'verify_token' => null,
        ]);
    }

    /**
     * @param string $surname
     * @param string $firstname
     * @param string $secondname
     * @return void
     */
    public function setNameField(string $surname = '', string $firstname = '', string $secondname = '')
    {
        if (!empty($surname)) $this->fullname->surname = $surname;
        if (!empty($firstname)) $this->fullname->firstname = $firstname;
        if (!empty($secondname)) $this->fullname->secondname = $secondname;
        $this->save();
    }
}
