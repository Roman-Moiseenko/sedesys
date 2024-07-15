<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Entity\Product;
use App\Modules\Product\Requests\ProductRequest;
use App\Modules\Product\Resources\ProductResource;
use App\Modules\Product\Service\ProductService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{

    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        [$column, $order] = explode(',', $request->input('sortBy', 'id,asc'));
        $pageSize = (int) $request->input('pageSize', 10);

        $resource = Product::query()
            ->when($request->filled('search'), function (Builder $q) use ($request) {
                $q->where(Product::COLUMN_NAME, 'like', '%'.$request->search.'%');
            })
            ->orderBy($column, $order)->paginate($pageSize);

        return ProductResource::collection($resource);
    }

    /**
     * Store a newly created resource in storage.
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $product = new Product($data);
        $product->save();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully created',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $product->fill($data)->save();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully updated',
        ]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully deleted',
        ]);
    }
}
