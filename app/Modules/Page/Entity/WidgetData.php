<?php
declare(strict_types=1);

namespace App\Modules\Page\Entity;

interface WidgetData
{
    public function getImage(string $thumb = ''): ?string;
    public function getIcon(string $thumb = ''): ?string;

    public function getUrl(): string;

    public function getCaption(): string;

    public function getText(): string;
}
