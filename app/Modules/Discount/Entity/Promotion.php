<?php

namespace App\Modules\Discount\Entity;

use App\Modules\Base\Entity\DisplayedModel;
use App\Modules\Page\Entity\WidgetData;
use App\Modules\Service\Entity\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $description
 * @property string $condition_url //Ссылка на страницу с условиями и правилами
 * @property Carbon $start_at
 * @property Carbon $finish_at
 * @property bool $current //по Cron if ($start_at > time() && $active) $current = true;
 * @property int $discount
 * @property Service[] $services
 * @property Service[] $items
 */
class Promotion extends DisplayedModel implements WidgetData
{
    use HasFactory;

    const STATUS_DRAFT = 101;
    const STATUS_WAITING = 102;
    const STATUS_STARTED = 103;
    const STATUS_FINISHED = 104;

    const STATUSES = [
        self::STATUS_DRAFT => 'Черновик',
        self::STATUS_WAITING => 'В ожидании',
        self::STATUS_STARTED => 'Запущена',
        self::STATUS_FINISHED => 'Завершена',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'finish_at' => 'datetime',
    ];


    /**
     * Ф-ции состояния
     */

    /**
     * Акция завершена окончательно
     * @return bool
     */
    public function isFinished(): bool
    {
        if ($this->active && $this->finish_at->lt(now()) && !$this->current) return true;
        return false;
    }

    /**
     * Акция в ожидании
     * @return bool
     */
    public function isWaiting(): bool
    {
        if (
            $this->active &&  //активна
            ((empty($this->start_at) && (empty($this->finish_at))) || $this->finish_at->lte(now())) && //без расписания или финиш еще не наступил
            !$this->current //еще не запущен
        ) return true;
        return false;
    }

    /**
     * Акция по расписанию
     * @return bool
     */
    public function isSchedule(): bool
    {
        return !is_null($this->start_at) && !is_null($this->finish_at);
    }

    /**
     * Действующая акция
     * @return bool
     */
    public function isCurrent(): bool
    {
        return $this->current;
    }

    public function isService(int $service_id): bool
    {
        foreach ($this->services as $service) {
            if ($service->id == $service_id) return true;
        }
        return false;
    }

    /**
     * Сетеры
     */
    public function finish()
    {
        $this->current = false;
    }

    public function start()
    {
        $this->activated_at = now();
        $this->current = true;
    }

    public function activated()
    {
        //Перезаписываем функцию, убрали установку время активации, перенесено в start()
        $this->active = true;
        $this->save();
    }

    /**
     * Гетеры
     */
    public function getStartAt(): string
    {
        return is_null($this->start_at) ? '' : $this->start_at->translatedFormat('j F Y');
    }

    public function getFinishAt(): string
    {
        return is_null($this->finish_at) ? '' : $this->finish_at->translatedFormat('j F Y');
    }

    public function status(): int
    {
        if ($this->current) return self::STATUS_STARTED; //'Действующая';
        if (!$this->active) return self::STATUS_DRAFT; // Черновик
        if ($this->isSchedule()) {
            if ($this->finish_at->lt(now())) return self::STATUS_FINISHED;
            if ($this->start_at->gte(now())) return self::STATUS_WAITING;
        }

        return self::STATUS_WAITING;
        //throw new \DomainException('Неучтенная комбинация!!!');
    }

    public function statusText(): string
    {
        return self::STATUSES[$this->status()];
    }

    /**
     * Отношения
     */

    /**
     * Универсальная ф-ция возврата элементов, в дальнейшем будет Products
     * Возможно добавить Интерфейс с ценой и др. данными
     */
    public function items()
    {
        if (!empty($this->services)) return $this->services();
        /**  if (!empty($this->products)) return $this->products(); */
        return null;
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'promotions_services', 'promotion_id', 'service_id')->withPivot('price');
    }
    /**
     * На будущее
     * public function products()
     * {
     * return $this->belongsToMany(Product::class, 'promotions_products', 'promotion_id', 'product_id');
     * }*/

    /**
     * Хелперы и Интерфейсы
     */
    public function getCacheKeys(): array
    {
        return [
            'promotions',
            'promotion-' . $this->id
        ];
    }

    public function getUrl(): string
    {
        return route('web.promotion.view', $this->slug);
    }

    public function getCaption(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->description;
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->where(function($query) {
            $query->where('finish_at', null)->orWhere('finish_at', '<', now());
        });
    }

}
