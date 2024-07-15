<?php
declare(strict_types=1);

namespace App\Modules\Employee\Entity;

use App\Modules\Base\Entity\FullName;
use App\Modules\Base\Entity\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name //Логин
// * @property string $email //Для защищенной аутентификации - простой способ
 * @property string $phone //  - сложный способ
 * @property string $password
 * @property bool $active //Не заблокирован
 * @property string $post //Должность
 * @property int $telegram_user_id
 * @property float $rating
 * @property FullName $fullname
 * @property Photo $photo
 * @property Specialization[] $specializations
 */
class Employee extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

}
