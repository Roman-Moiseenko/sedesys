<?php
declare(strict_types=1);

namespace App\Modules\Order\Entity;

use App\Modules\Admin\Entity\Admin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property int $order_id
 * @property int $staff_id
 * @property Carbon $created_at
 *
 * @property string $action - действие
 * @property string $object - объект изменения
 * @property string $value - новое значение
 * @property string $url - ссылка на объект
 *
 * @property Admin $staff
 * @property Order $order
 */
class OrderHistory extends Model
{
    protected $table = 'order_history';
    public $timestamps = false;
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'staff_id',
        'action',
        'object',
        'value',
        'url',
        'created_at',
    ];

    /**
     * Функция зависима от Авторизации Admin::class
     * @param string $action
     * @param string $object
     * @param string $value
     * @param string $url
     * @return static
     */
    public static function new(string $action = '', string $object = '', string $value = '', string $url = ''): self
    {
        /**
         * Зависимость от Auth !!!!
         */
        $staff = Auth::guard('admin')->user();
        return self::make([
            'staff_id' => is_null($staff) ? null : $staff->id,
            'action' => $action,
            'object' => $object,
            'value' => $value,
            'url' => $url,
            'created_at' => now(),
        ]);
    }

    public function staff()
    {
        return $this->belongsTo(Admin::class, 'staff_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
