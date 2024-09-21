<?php

namespace App\Modules\Feedback\Repository;

use App\Modules\Feedback\Entity\Template;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Feedback\Entity\Feedback;

class FeedbackRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Feedback::orderByDesc('created_at')->where('archive', true);
        /**
         * Фильтр, для каждого параметра своя проверка
         */
        $filters = [];
        if (($template = $request->integer('template')) > 0) {
            $filters['template'] = $template;
            $query->where('template_id', $template);
        }
        if (($staff = $request->integer('staff')) > 0) {
            $filters['staff'] = $staff;
            $query->where('staff_id', $staff);
        }
        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Feedback $feedback) => $this->FeedbackToArray($feedback));
    }


    public function FeedbackToArray(Feedback $feedback): array
    {
        return [
            'id' => $feedback->id,
            'template' => $feedback->template->name,
            'user' => $feedback->user,
            'email' => $feedback->email,
            'phone' => $feedback->phone,
            'message' => $feedback->message,
            'data' => $feedback->data,
            'created_at' => $feedback->created_at->translatedFormat('d-m-Y H:i'),
            'staff' => is_null($feedback->staff_id) ? '' : $feedback->staff->fullname->getFullName(),
            'archive' => $feedback->isArchive(),
            'status' => $feedback->status,
            'status_html' => $feedback->statusHtml(),
            'completed' => $feedback->isCompleted(),
            'order_id' => $feedback->order_id,

            'url' => route('admin.feedback.feedback.show', $feedback),

            'to_archive' => route('admin.feedback.feedback.to-archive', $feedback),
            'from_archive' => route('admin.feedback.feedback.from-archive', $feedback),
            'to_email' => route('admin.feedback.feedback.to-email', $feedback),
            'to_order' => route('admin.feedback.feedback.to-order', $feedback),
            'to_completed' => route('admin.feedback.feedback.to-completed', $feedback),
            'set_staff' => route('admin.feedback.feedback.set-staff', $feedback),
        ];
    }

    public function FeedbackWithToArray(Feedback $feedback): array
    {
        $withData = [
            /**
             * Данные из relations
             */
        ];

        return array_merge($this->FeedbackToArray($feedback), $withData);
    }

    public function getDashboards()
    {
        return Template::orderBy('name')->where('active', true)->get()->map(function (Template $template) {
            return [
                'id' => $template->id,
                'name' => $template->name,
                'color' => $template->color,
                'feedbacks' => $template
                    ->feedbacks()
                    ->where('archive', false)
                    ->get()
                    ->map(fn(Feedback $feedback) => $this->FeedbackToArray($feedback))->toArray(),
            ];
        })->toArray();
    }
}
