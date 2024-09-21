<?php

namespace App\Modules\Feedback\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Entity\Responsibility;
use App\Modules\Admin\Repository\StaffRepository;
use App\Modules\Feedback\Entity\Feedback;
use App\Modules\Feedback\Entity\Template;
use App\Modules\Feedback\Repository\TemplateRepository;
use App\Modules\Feedback\Requests\FeedbackRequest;
use App\Modules\Feedback\Repository\FeedbackRepository;
use App\Modules\Feedback\Service\FeedbackService;
use App\Modules\Order\Entity\Order;
use App\Modules\Order\Service\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use function Symfony\Component\Translation\t;

class FeedbackController extends Controller
{

    private FeedbackService $service;
    private FeedbackRepository $repository;
    private StaffRepository $staffs;
    private TemplateRepository $templates;

    public function __construct(
        FeedbackService    $service,
        FeedbackRepository $repository,
        StaffRepository    $staffs,
        TemplateRepository $templates,

    )
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->staffs = $staffs;
        $this->templates = $templates;
    }


    public function dashboard()
    {
        $dashboards = $this->repository->getDashboards();
        $staffs = $this->staffs->getActiveByResponsibility(Responsibility::MANAGER_FEEDBACK);
        return Inertia::render('Feedback/Feedback/Dashboard', [
                'dashboards' => $dashboards,
                'staffs' => $staffs,
            ]
        );
    }

    public function index(Request $request)
    {
        $feedback = $this->repository->getIndex($request, $filters);
        $templates = $this->templates->forFilter();

        $staffs = $this->staffs->forFilter(Responsibility::MANAGER_FEEDBACK);
        return Inertia::render('Feedback/Feedback/Index', [
                'feedback' => $feedback,
                'filters' => $filters,
                'templates' => $templates,
                'staffs' => $staffs,
            ]
        );
    }

    public function show(Feedback $feedback)
    {
        $feedback = $this->repository->FeedbackWithToArray($feedback);

        return Inertia::render('Feedback/Feedback/Show', [
                'feedback' => $feedback,
                'edit' => route('admin.feedback.feedback.edit', $feedback),
            ]
        );
    }

    public function to_archive(Feedback $feedback)
    {
        $feedback->archive();
        return redirect()->back()->with('success', 'Заявка отправлена в архив');
    }

    public function to_completed(Feedback $feedback)
    {
        $feedback->completed();
        return redirect()->back()->with('success', 'Заявка Завершена');
    }

    public function to_email(Feedback $feedback)
    {
        /*$feedback->status = Feedback::STATUS_WORK;
        $feedback->save();*/
        $feedback->status = Feedback::STATUS_WORK;
        $feedback->save();
        return redirect()->route('admin.mail.outbox.create', ['email' => $feedback->email, 'subject' => 'Re: ' . $feedback->template->name]);
    }

    public function to_order(Feedback $feedback)
    {
        $order = $this->service->createOrder($feedback);

        return redirect()->route('admin.order.order.show', $order);
    }

    public function from_archive(Feedback $feedback)
    {
        $feedback->cancelArchive();
        return redirect()->back()->with('success', 'Заявка возвращена в работу');
    }

    public function set_staff(Request $request, Feedback $feedback)
    {
        $feedback->setStaff($request->integer('staff'));
        return redirect()->back()->with('success', 'Менеджер назначен вручную.');
    }
}
