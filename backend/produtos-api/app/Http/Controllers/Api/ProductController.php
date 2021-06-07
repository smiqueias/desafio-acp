<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private Product $product;

    public function __construct(Product $product)
    {
        return $this->product = $product;
    }

    public function index() : JsonResponse
    {
        $products = Product::paginate(10);

        return response()->json([
            'data' => $products,
        ],200);
    }

    public function store(ProductRequest $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $product = $this->product->create($data);
            return response()->json([
                'data' => [
                    'msg' => 'Produto registrado com sucesso!'
                ]
            ],201);
        } catch (\Exception $exception) {
             return response()->json($exception->getMessage(),401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
