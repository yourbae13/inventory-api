<?php 
  
namespace App\Http\Controllers\Api; 
  
use App\Http\Controllers\Controller;
use App\Models\Product; 
use Illuminate\Http\JsonResponse; 
use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
  
class ProductController extends Controller 
 { 
     public function index(): JsonResponse 
     { 
         $rows = Product::query()->latest('id')->get(); 
  
        return response()->json([ 
             'data' => $rows->map(fn (Product $row) => $this->data($row)), 
         ]); 
     } 
  
    public function store(Request $request): JsonResponse 
     { 
         $product = Product::create($this->validated($request, false)); 
  
        return response() 
             ->json(['data' => $this->data($product)], 201) 
             ->header('Location', route('products.show', $product, false)); 
     } 
  
    public function show(Product $product): JsonResponse 
     { 
         return response()->json(['data' => $this->data($product)]); 
     } 
  
    public function update(Request $request, Product $product): JsonResponse 
     { 
         $product->update($this->validated($request, $request->isMethod('PATCH'))); 
  
        return response()->json(['data' => $this->data($product)]); 
     } 
  
    public function destroy(Product $product): Response 
     { 
         $product->delete(); 
  
        return response()->noContent(); 
     } 

     private function validated(Request $request, bool $partial): array 
     { 
         $presence = $partial ? 'sometimes|required' : 'required'; 
  
        return $request->validate([ 
             'name' => $presence . '|string|max:100', 
             'price' => $presence . '|integer|min:0|max:2147483647', 
             'stock' => $presence . '|integer|min:0|max:2147483647', 
         ]); 
     } 
  
    private function data(Product $product): array 
     { 
         return [ 
             'id' => $product->id, 
             'name' => $product->name, 
             'price' => $product->price, 
             'stock' => $product->stock, 
         ]; 
     } 
 } 