<?php
declare(strict_types=1);

namespace App\Modules\Service\Service;


use App\Modules\Service\Entity\Extra;
use App\Modules\Service\Requests\ExtraRequest;
use Illuminate\Http\Request;

class ExtraService
{

    public function create(Request $request)
    {
        $extra = Extra::register(
            $request->integer('service_id'),
            $request->string('name')->trim()->value()
        );

        $this->save_fields($extra, $request);
        return $extra;
    }

    public function update(Extra $extra, Request $request)
    {
        $extra->name = $request->string('name')->trim()->value();
        $this->save_fields($extra, $request);
        return $extra;
    }

    private function save_fields(Extra $extra, Request $request)
    {
        $extra->description = $request->string('description')->trim()->value();
        $extra->price = $request->input('price');
        $extra->duration = $request->input('duration');
        $extra->awesome = $request->string('awesome')->trim()->value();
        $extra->save();
        $this->saveIcon($extra, $request);
    }

    public function destroy(Extra $extra)
    {
        $extra->delete();
    }

    public function up(Extra $extra)
    {
        /** @var Extra[] $extras */
        $extras = Extra::where('service_id', $extra->service_id)->orderBy('sort')->getModels();
        for ($i = 1; $i < count($extras); $i++) {
            if ($extras[$i]->id == $extra->id) {
                $prev = $extras[$i - 1]->sort;
                $next = $extras[$i]->sort;
                $extras[$i]->setSort($prev);
                $extras[$i - 1]->setSort($next);
            }
        }
    }

    public function down(Extra $extra)
    {
        /** @var Extra[] $extras */
        $extras = Extra::where('service_id', $extra->service_id)->orderBy('sort')->getModels();
        for ($i = 0; $i < count($extras) - 1; $i++) {
            if ($extras[$i]->id == $extra->id) {
                $prev = $extras[$i + 1]->sort;
                $next = $extras[$i]->sort;
                $extras[$i]->setSort($prev);
                $extras[$i + 1]->setSort($next);
            }
        }
    }

    private function saveIcon(Extra $extra, Request $request): void
    {
        $clear_current = $request->boolean('clear_icon');
        $file = $request->file('icon');
        if ($clear_current && (!is_null($extra->icon) || !is_null($extra->icon->file)))
            $extra->icon->delete();

        if (empty($file)) return;
        $extra->icon->newUploadFile($file);
    }
}
