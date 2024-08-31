<?php
declare(strict_types=1);

namespace App\Modules\Service\Entity;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class ExternalReview
{
    const AVITO = 'avito';
    const EXTERNAL_NAME = [
        self::AVITO => 'Авито'
    ];
    const EXTERNAL_URL = [
        self::AVITO => 'https://avito.ru'
    ];
    const EXTERNAL_LOGO = [
        self::AVITO => '/resources/images/external/avito.ru'
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
