<?php
declare(strict_types=1);

namespace App\Modules\Setting\Entity;

class Office extends AbstractSetting
{
    public string $name;
    public string $open_hours;
    public string $longitude;
    public string $latitude;
    public string $city;
    public string $address;
    public array $phones;

    public string $payment;
    public string $prices;
    public string $rating_value;
    public string $rating_count;
    public string $rating_url;

    public string $brand_name;
    public array $brand_alternate;
    public array $brand_sameas;

}
