<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Http\Interfaces\ProductsInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProductsRepository implements ProductsInterface
{
    use ApiResponseTrait;


    public function products()
    {
        $products = Product::get();
        return $this->apiResponse(200, 'products', null, $products);
    }
}
