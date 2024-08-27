<?php
declare(strict_types=1);

namespace App\Modules\Web\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Page\Entity\Page;

class SitemapXmlController extends Controller
{

    public function index()
    {
        $pages = array_merge(
         //   $this->products(),
        // //   $this->services(),
         //   $this->categories(),
            $this->pages(),
            $this->static(),
           // $this->promotions(),
        );
        $content = view('web.sitemap', compact('pages'))->render();
        ob_end_clean();
        return response($content)->header('Content-Type','text/xml');
    }

/*
    private function services(): array
    {
        return array_map(function (Service $product) {
            return [
                'url' => route('web.product.view', $product->slug),
                'date' => $product->updated_at->format('c'),
                'changefreq' => 'weekly'
            ];
        }, Service::active()->getModels());
    }*/
/*
    private function products(): array
    {
        return array_map(function (Product $product) {
            return [
                'url' => route('web.product.view', $product->slug),
                'date' => $product->updated_at->format('c'),
                'changefreq' => 'weekly'
            ];
        }, Product::where('published', true)->getModels());
    }*/
/*
    private function categories(): array
    {
        return array_map(function (Category $category) {
            return [
                'url' => route('web.category.view', $category->slug),
                'date' => now()->format('c'),
                'changefreq' => 'weekly'
            ];
        }, Category::getModels());
    }

*/
    private function pages(): array
    {
        return array_map(function (Page $page) {
            return [
                'url' => route('web.page.view', $page->slug),
                'date' => $page->updated_at->format('c'),
                'changefreq' => 'weekly'
            ];
        }, Page::active()->getModels());
    }

    private function static(): array
    {
        return array_map(function ($item) {
            return [
                'url' => route($item),
                'date' => now()->format('c'),
                'changefreq' => 'daily'
            ];
        }, ['web.home']);
    }
/*
    private function promotions(): array
    {
        return array_map(function (Promotion $promotion) {
            return [
                'url' => route('web.promotion.view', $promotion->slug),
                'date' => $promotion->start_at->format('c'),
                'changefreq' => 'weekly'
            ];
        }, Promotion::active()->where('active', true)->getModels());
    }
*/
}
