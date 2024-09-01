<?php
declare(strict_types=1);

namespace App\Modules\Service\Entity;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class ExternalReview
{

    const AVITO = 'avito';
    const VK = 'vk';
    const PRODOCTOROV = 'prodoctorov';
    const OTZOVIK = 'otzovik';
    const YANDEX_MAP = 'yandex_map';
    const IRECOMMEND = 'irecommend';
    const TWO_GIS = '2gis';

    const EXTERNAL_NAME = [
        self::AVITO => 'Авито',
        self::VK => 'ВКонтакте',
        self::PRODOCTOROV => 'Продокторов',
        self::OTZOVIK => 'Отзовик',
        self::YANDEX_MAP => 'Яндекс карты',
        self::IRECOMMEND => 'Я рекомендую',
        self::TWO_GIS => '2 ГИС',
    ];
    const EXTERNAL_URL = [
        self::AVITO => 'https://avito.ru',
        self::VK => 'https://vk.com/',
        self::PRODOCTOROV => 'https://prodoctorov.ru/',
        self::OTZOVIK => 'https://otzovik.com/',
        self::YANDEX_MAP => 'https://yandex.ru/maps',
        self::IRECOMMEND => 'https://irecommend.ru/',
        self::TWO_GIS => 'https://2gis.ru/',

    ];
    const EXTERNAL_LOGO = [
        self::AVITO => '/images/external/avito.jpg',
        self::VK => '/images/external/vk.jpg',
        self::PRODOCTOROV => '/images/external/prodoctorov.jpg',
        self::OTZOVIK => '/images/external/otzovik.jpg',
        self::YANDEX_MAP => '/images/external/yandex_map.jpg',
        self::IRECOMMEND => '/images/external/irecommend.jpg',
        self::TWO_GIS => '/images/external/gis.jpg',

    ];

    public string $external;
    public string $user_name;
    public string $link_review;

    #[ArrayShape(['name' => "string", 'url' => "string", 'logo' => "string"])]
    public function getData(): array
    {
        return [
            'name' => self::EXTERNAL_NAME[$this->external],
            'url' =>  self::EXTERNAL_URL[$this->external],
            'logo' =>  self::EXTERNAL_LOGO[$this->external],
        ];
    }

    public static function fromArray(?array $params): self
    {
        $full = new static();
        if (!empty($params)) {
            $full->external = $params['external'];
            $full->user_name = $params['user_name'];
            $full->link_review = $params['link_review'];
        }
        return $full;
    }

    public function toArray(): array
    {
        return [
            'external' => $this->external,
            'user_name' => $this->user_name,
            'link_review' => $this->link_review,
        ];
    }

    public function getNameService(): string
    {
        return self::EXTERNAL_NAME[$this->external];
    }
    public function __construct(string $external = '', string $user_name = '', string $link_review = '', array $params = [])
    {
        if (!empty($params)) {
            $this->external = $params['external'] ?? '';
            $this->user_name = $params['user_name'] ?? '';
            $this->link_review = $params['link_review'] ?? '';
        } else {
            $this->external = $external;
            $this->user_name = $user_name;
            $this->link_review = $link_review;
        }
    }

    public static function fromRequest(Request $request): self
    {
        return new static(
            external: $request->string('external')->trim()->value(),
            user_name: $request->string('user_name')->trim()->value(),
            link_review: $request->string('link_review')->trim()->value()
        );
    }
}
