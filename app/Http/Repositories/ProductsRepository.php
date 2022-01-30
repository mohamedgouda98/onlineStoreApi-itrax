<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\ProductsInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Product;
use App\Rules\ProductExistsRule;
use Illuminate\Support\Facades\Validator;

class ProductsRepository implements ProductsInterface
{
    use ApiResponseTrait;



    public function products()
    {
        $products = Product::get();
        return $this->apiResponse(200, 'products', null, $products);
    }

    public function create($request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        if($validation->fails())
        {
            return $this->apiResponse(400, 'validation error', $validation->errors());
        }

        Product::create($validation->validated());

        return $this->apiResponse(200, 'Product was created');
    }

    public function update($request)
    {
        $validation = Validator::make($request->all(),[
            'id' => ['required','integer',new ProductExistsRule()],
            'name' => 'string',
            'price' => 'numeric',
            'stock' => 'integer'
        ]);

        if($validation->fails())
        {
            return $this->apiResponse(400, 'validation error', $validation->errors());
        }

        $product = Product::find($request->id);

        $product->update($validation->validated());

        return $this->apiResponse(200, 'Product was updated');
    }

    public function delete($request)
    {
        $validation = Validator::make($request->all(),[
            'id' => ['required',new ProductExistsRule()],
        ]);

        if($validation->fails())
        {
            return $this->apiResponse(400, 'validation error', $validation->errors());
        }

        $product = Product::find($request->id);

        $product->delete();

        return $this->apiResponse(200, 'Product was deleted');
    }

    public function archive()
    {
        $products = Product::onlyTrashed()->get();

        return $this->apiResponse(200, 'products archive', null, $products);
    }
}
