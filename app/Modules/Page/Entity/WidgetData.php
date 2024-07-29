<?php
declare(strict_types=1);

namespace App\Modules\Page\Entity;

interface WidgetData
{
    public function getImage(): ?string;

    public function getUrl(): string;

    public function getCaption(): string;

    public function getText(): string;
}
