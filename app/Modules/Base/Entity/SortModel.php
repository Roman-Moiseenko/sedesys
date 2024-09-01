<?php
declare(strict_types=1);

namespace App\Modules\Base\Entity;

interface SortModel
{
    public function setSort(int $sort): void;
    public function getSort(): int;
    public function isEqual(SortModel $model): bool;
}
