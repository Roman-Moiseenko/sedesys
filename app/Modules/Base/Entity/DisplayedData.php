<?php
declare(strict_types=1);

namespace App\Modules\Base\Entity;

interface DisplayedData
{
    public function getImage(string $thumb = ''): ?string;
    public function getIcon(string $thumb = ''): ?string;
    public function getAwesome(): string;
    public function scopeActive($query);

}
