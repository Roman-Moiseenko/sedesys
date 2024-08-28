<?php
declare(strict_types=1);

namespace App\Modules\Base\Entity;

use Illuminate\Http\Request;

class BreadcrumbInfo
{
    public int $photo_id = 0;
    public string $caption = '';
    public string $description = '';

    public static function fromRequest(Request $request): self
    {
        return new static(
            photo_id: $request->integer('photo_id'),
            caption: $request->string('caption')->trim()->value(),
            description: $request->string('description')->trim()->value()
        );
    }

    /**
     * @param int $photo_id
     * @param string $caption
     * @param string $description
     * @param array $params - Альтернативный способ заполнения ['photo_id' => 0, 'caption' => '', 'description' => '']
     */
    public function __construct(int $photo_id = 0, string $caption = '', string $description = '', array $params = [])
    {
        if (!empty($params)) {
            $this->photo_id = (int)$params['photo_id'] ?? 0;
            $this->caption = $params['caption'] ?? '';
            $this->description = $params['description'] ?? '';
        } else {
            $this->photo_id = $photo_id;
            $this->caption = $caption;
            $this->description = $description;
        }
    }

    public function getImage(string $thumb = ''): ?string
    {
        if ($this->photo_id == 0) return null;

        $photo = Photo::find($this->photo_id);
        if (empty($thumb)) return $photo->getUploadUrl();
        return $photo->getThumbUrl($thumb);
    }

    public static function fromArray(?array $params): self
    {
        $breadcrumb = new static();
        if (!empty($params)) {
            $breadcrumb->photo_id = $params['photo_id'];
            $breadcrumb->caption = $params['caption'];
            $breadcrumb->description = $params['description'];
        }
        return $breadcrumb;
    }

    public function toArray(): array
    {
        return [
            'photo_id' => $this->photo_id,
            'caption' => $this->caption,
            'description' => $this->description,
        ];
    }
}
