<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Feedback\Entity\Template;
use App\Modules\Feedback\Events\FeedbackHasSend;
use App\Modules\Feedback\Service\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    private FeedbackService $service;

    public function __construct(FeedbackService $service)
    {
        $this->service = $service;
    }

    public function get_form(Request $request)
    {
        $template = Template::find($request->integer('id'));
        if (!$template->isActive()) return response()->json(['html' => '']);

        $html = $template->template;
        return response()->json(['html' => $html, 'route' => route('web.feedback.send-form')]);
    }

    public function send_form(Request $request)
    {
        try {
            $feedback = $this->service->create($request);
            event(new FeedbackHasSend($feedback));
            return response()->json(['html' => 'Ваша заявка принята!<br>' . '№ заявки ' . $feedback->id]);
        } catch (\Throwable $e) {
            return response()->json(['html' => $e->getMessage()]);
        }


    }
}
