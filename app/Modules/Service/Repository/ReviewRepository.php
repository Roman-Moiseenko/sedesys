<?php

namespace App\Modules\Service\Repository;

use App\Modules\Service\Entity\ExternalReview;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use App\Modules\Service\Entity\Review;

class ReviewRepository
{

    public function getIndex(Request $request, &$filters): Arrayable
    {
        $query = Review::orderByDesc('created_at');
        /**
         * Фильтр, для каждого параметра своя проверка
         */
        $filters = [];

        if ($request->has('rating') && $request->integer('rating') != 0) {
            $rating = $request->integer('rating');
            $filters['rating'] = $rating;
            $query->where('rating', $rating);
        }

        if ($request->has('service_id')) {
            $service_id = $request->integer('service_id');
            $filters['service_id'] = $service_id;
            $query->where('service_id', $service_id);
        }

        if ($request->has('employee_id')) {
            $employee_id = $request->integer('employee_id');
            $filters['employee_id'] = $employee_id;
            $query->where('employee_id', $employee_id);
        }

        if (count($filters) > 0) $filters['count'] = count($filters); //Кол-во выбранных элементов в поиске
        return $query->paginate($request->input('size', 20))
            ->withQueryString()
            ->through(fn(Review $review) => $this->ReviewToArray($review));
    }


    public function ReviewToArray(Review $review): array
    {
        return [
            'id' => $review->id,
            'from' => $review->getFrom(),
            'rating' => $review->rating,
            'text' => $review->text,
            'image_count' => count($review->gallery),
            'service' => is_null($review->service_id) ? '' : $review->service->name,
            'employee' => is_null($review->employee_id) ? '' : $review->employee->fullname->getFullName(),
            'created_at' => $review->created_at->translatedFormat('j F Y'),
            'active' => $review->isActive(),
            'is_edit' => is_null($review->user_id),
        ];
    }

    public function getExternals(): array
    {
        return array_select(ExternalReview::EXTERNAL_NAME);
    }

    public function getPhotos(Review $review): array
    {
        $result = [];
        foreach ($review->gallery as $photo) {
            $result[] = [
                'id' => $photo->id,
                'name' => $photo->file,
                'url' => $photo->getThumbUrl('original'),
                'alt' => $photo->alt,
                /*'title' => $photo->title,
                'description' => $photo->description,*/
            ];
        }
        return $result;
    }
}
