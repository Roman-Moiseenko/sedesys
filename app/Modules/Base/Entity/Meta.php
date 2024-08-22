<?php
declare(strict_types=1);

namespace App\Modules\Base\Entity;

use Illuminate\Http\Request;

class Meta
{
    public string $h1 = '';
    public string $title = '';
    public string $description = '';

    public static function fromRequest(Request $request): self
    {
        return new static(
            h1: $request->string('h1')->trim()->value(),
            title: $request->string('title')->trim()->value(),
            description: $request->string('description')->trim()->value()
        );
    }

    public function __construct(string $h1 = '', string $title = '', string $description = '')
    {
        $this->h1 = $h1;
        $this->title = $title;
        $this->description = $description;
    }

    public static function fromArray(?array $params): self
    {
        $meta = new static();
        if (!empty($params)) {
            $meta->h1 = $params['h1'];
            $meta->title = $params['title'];
            $meta->description = $params['description'];
        }
        return $meta;
    }

    public function toArray(): array
    {
        return [
            'h1' => $this->h1,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
