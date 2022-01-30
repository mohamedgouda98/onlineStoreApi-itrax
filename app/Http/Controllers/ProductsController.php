<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ProductsInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    use ApiResponseTrait;
    public $productsInterface;

    public function __construct(ProductsInterface $productsInterface)
    {
        $this->productsInterface = $productsInterface;
    }

    public function products()
    {
        return $this->productsInterface->products();
    }

    public function create(Request $request)
    {
        if($request->user()->hasRole(['admin','supplier']))
        {
            return $this->productsInterface->create($request);
        }
        return $this->apiResponse(400, 'Action not authorized');
    }

    public function update(Request $request)
    {
        if($request->user()->hasRole(['admin','supplier']))
        {
            return $this->productsInterface->update($request);
        }
        return $this->apiResponse(400, 'Action not authorized');
    }

    public function delete(Request $request)
    {
        if($request->user()->hasRole('admin'))
        {
            return $this->productsInterface->delete($request);
        }
        return $this->apiResponse(400, 'Action not authorized');
    }

    public function archive()
    {
        return $this->productsInterface->archive();
    }
}
