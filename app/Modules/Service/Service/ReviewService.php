<?php

namespace App\Modules\Service\Service;

use App\Modules\Base\Entity\Photo;
use App\Modules\Service\Entity\ExternalReview;

use Illuminate\Http\Request;
use App\Modules\Service\Entity\Review;

class ReviewService
{

    public function create(Request $request): Review
    {
        $review = Review::register(
            $request->integer('service_id'),
        );
        $this->save_fields($review, $request);

        return  $review;
    }

    public function update(Review $review, Request $request)
    {
        $review->service_id = $request->integer('service_id');
        $review->save();

        $this->save_fields($review, $request);
    }

    private function save_fields(Review $review, Request $request)
    {
        $review->external = ExternalReview::fromRequest($request);
        $review->employee_id = $request->input('employee_id', null);
        $review->rating = $request->integer('rating');
        $review->text = $request->string('text')->trim()->value();
        $review->active = true;
        $review->save();
    }


    public function destroy(Review $review)
    {
        $review->delete();
    }

    /**
     * Функции на создание отзыва клиентом
     * @param Request $request
     * @return Review
     */
    public function create_user(Request $request): Review
    {
        $review = Review::register(
            $request->integer('service_id'),
        );
        $review->user_id = $request->integer('user_id');
        $review->rating = $request->integer('rating');
        $review->text = $request->string('text')->trim()->value();
        $review->active = false;
        $review->save();

        if ($request->has('photos')) {
            foreach ($request->file('photos') as $file) {
                $review->gallery()->save(Photo::upload($file));
            }
        }

        return $review;
    }



}
