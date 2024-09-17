<?php
declare(strict_types=1);

namespace App\Modules\Admin\Entity;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $admin_id
 * @property int $code
 */
class Responsibility extends Model
{
    protected $table = 'responsibilities';
    protected $fillable = [
        'code',
    ];

    public $timestamps = false;

    //Работа с клиентом, Заказы
    public const MANAGER_ORDER = 1001; // order
    public const MANAGER_REVIEW = 1002; //review
    public const MANAGER_FEEDBACK = 1003; //feedback
    public const MANAGER_USER = 1004; //user
    public const MANAGER_DELIVERY = 1005; //delivery
    public const MANAGER_REQUEST = 1006; //request
    public const MANAGER_LOGGER = 1007; //logger
    public const MANAGER_RECORD = 1008; //record

    //Учет
    public const MANAGER_ACCOUNTING = 1011; //accounting
    public const MANAGER_SUPPLY = 1012; //supply

    //Финансы
    public const MANAGER_PAYMENT = 1021; //paid
    public const MANAGER_REFUND = 1022; //refund
    public const MANAGER_DISCOUNT = 1023; //discount
    public const MANAGER_PRICING = 1024; //pricing

    //Сущности
    public const MANAGER_PRODUCT = 1031; //product
    public const MANAGER_SERVICE = 1032; //product

    //Управление и Настройки
    public const MANAGER_STAFF = 1041; //staff
    public const MANAGER_SETTINGS = 1042; //options
    public const MANAGER_EMPLOYEE = 1043; //employee

    //Отчеты
    public const REPORT_THROWABLE = 1051;
    public const REPORT_OTHER = 1052;

    //Отчеты и/или Контроль
    const RESPONSE = [
        self::MANAGER_ORDER => 'Работа с заказами',
        self::MANAGER_USER => 'Доступ к данным о клиенте',
        self::MANAGER_REVIEW => 'Работа с отзывами',
        self::MANAGER_FEEDBACK => 'Обратная связь',
        self::MANAGER_REQUEST => 'Заявка с сайта', //TODO ????
        self::MANAGER_DELIVERY => 'Доставка товаров',
        self::MANAGER_LOGGER => 'Сборка и выдача товаров',
        self::MANAGER_RECORD => 'Запись по Календарю',

        self::MANAGER_ACCOUNTING => 'Материальный учет',
        self::MANAGER_SUPPLY => 'Заказ товаров',

        self::MANAGER_DISCOUNT => 'Работа со скидками',
        self::MANAGER_PAYMENT => 'Работа с платежами',
        self::MANAGER_PRICING => 'Работа с ценам',
        self::MANAGER_REFUND => 'Работа с возвратами',

        self::MANAGER_PRODUCT => 'Товары, категории, атрибуты',
        self::MANAGER_SERVICE => 'Услуги, классификация',

        self::MANAGER_STAFF => 'Доступ к данным о сотруднике',
        self::MANAGER_EMPLOYEE => 'Доступ к данным персонала',
        self::MANAGER_SETTINGS => 'Настройки сайта',

        self::REPORT_THROWABLE => 'Report: Логи по ошибкам сайта',
        self::REPORT_OTHER => 'Report: Другие отчеты',
    ];

    public static function new(int $resp): self
    {
        return self::make(['code' => $resp]);
    }
}
