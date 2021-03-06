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

    public function index(Request $request) : JsonResponse
    {
        if ($request->has('nome')) {
            $nome = strtolower($request->nome);
            $query = Product::query();
            $query->where('name','LIKE', "{$nome}%")->get();
            $products = $query;
            return response()->json($products);
        }

        $products = Product::all();

        return response()->json(
            $products
        ,200);
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

    public function show(int $id) : JsonResponse
    {
        try {
            $product = $this->product->findOrFail($id);
            return response()->json([
                'data' => [
                    $product
                ]
            ],200);



        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),401);
        }
    }

    public function update(Request $request, int $id) : JsonResponse
    {
        $data = $request->all();
        try {
            $product = $this->product->findOrFail($id);
            $product->update($data);
            return response()->json([
                'data' => [
                    'msg' => 'Produto atualizado com sucesso!'
                ]
            ],201);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),401);
        }

    }

    public function destroy( $id ) : JsonResponse
    {
        try {
            $ids = explode(",",$id);
            //$product = $this->product->findOrFail($id);
            $this->product->whereIn('id',$ids)->delete();
            return response()->json([
                'data' => [
                    'msg' => 'Produto deletado com sucesso!'
                ]
            ],200);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(),401);
        }
    }
}
