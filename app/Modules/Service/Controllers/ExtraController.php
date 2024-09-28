<?php
declare(strict_types=1);

namespace App\Modules\Service\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Service\Entity\Extra;
use App\Modules\Service\Requests\ExtraRequest;
use App\Modules\Service\Requests\ServiceRequest;
use App\Modules\Service\Service\ExtraService;

class ExtraController extends Controller
{
    private ExtraService $service;

    public function __construct(ExtraService $service)
    {
        $this->service = $service;
    }

    public function store(ExtraRequest $request)
    {
        $request->validated();
        $this->service->create($request);
        return redirect()
            ->back()
            ->with('success', 'Услуга добавлена');
    }

    public function update(ExtraRequest $request, Extra $extra)
    {
        $request->validated();
        $this->service->update($extra, $request);
        return redirect()
            ->back()
            ->with('success', 'Услуга сохранена');
    }

    public function destroy(Extra $extra)
    {
        $this->service->destroy($extra);

        return redirect()->back()->with('success', 'Удаление прошло успешно');
    }

    public function toggle(Extra $extra)
    {
        if ($extra->isActive()) {
            $extra->draft();
            $success = 'Услуга отправлена в черновик';
        } else {
            $extra->activated();
            $success = 'Услуга доступна на сайте';
        }
        return redirect()->back()->with('success', $success);
    }
    public function up(Extra $extra)
    {
        $this->service->up($extra);
        return redirect()->back()->with('success', 'Сохранено');
    }

    public function down(Extra $extra)
    {
        $this->service->down($extra);
        return redirect()->back()->with('success', 'Сохранено');
    }

}
