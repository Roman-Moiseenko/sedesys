<?php

namespace App\Modules\Order\Entity;

use App\Modules\Admin\Entity\Admin;
use App\Modules\Base\Entity\Photo;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $order_id
 * @property int $staff_id
 * @property float $amount
 * @property int $method
 * @property string $document
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Admin $staff
 * @property Order $order
 */
class OrderPayment extends Model
{
    use HasFactory;

    const METHOD_CASH = 401; //В кассе
    const METHOD_TRANSFER = 402; //Перевод
    const METHOD_SBP = 403; //СБП
    const METHOD_ONLINE = 404; //ЮКасса

    const METHODS = [
        self::METHOD_CASH => 'В кассе', //
        self::METHOD_TRANSFER => 'Перевод', //
        self::METHOD_SBP => 'СБП', //
        self::METHOD_ONLINE => 'ЮКасса', //
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'order_id',
        'amount',
        'method'
    ];

    public static function register(int $order_id, float $amount, int $method): self
    {
        return self::create([
            'order_id' => $order_id,
            'amount' => $amount,
            'method' => $method,
        ]);
    }

    /**
     * Ф-ции состояния
     */
    public function isField(): bool
    {
        return true;
    }

    /**
     * Сетеры
     */
    public function setField($value): void
    {

        $this->field = $value;
        $this->save();
    }

    /**
     * Гетеры
     */
    public function getField(): mixed
    {

        return $this->field;
    }

    /**
     * Отношения
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Admin::class, 'staff_id', 'id');
    }

    /**
     * Хелперы и Интерфейсы
     */

    public function htmlDate(string $field = 'created_at'):string
    {
        return $this->$field->translatedFormat('d F Y H:i');
    }
}
