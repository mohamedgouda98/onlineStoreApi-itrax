<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\CartInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Cart;
use App\Rules\StockValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartRepository implements CartInterface
{
    use ApiResponseTrait;

    public function addToCart($request)
    {
       $validations = Validator::make($request->all(),[
           'product_id' => 'required|exists:products,id',
           'count' => ['required', new StockValidation($request->product_id)]
       ]);

       if($validations->fails())
       {
           return $this->apiResponse(400, 'validation error', $validations->errors());
       }

       $cart= Cart::where([ ['user_id', Auth::user()->id], ['product_id', $request->product_id] ])->first();

       if($cart)
       {

           $cart->update([
               'count' => ($cart->count + $request->count)
           ]);
       }else
       {
           Cart::create([
               'user_id' => Auth::user()->id,
               'product_id' => $request->product_id,
               'count' => $request->count
           ]);
       }

       return $this->apiResponse(200, 'added to cart');
    }

    public function deleteFromCart($request)
    {
        // TODO: Implement deleteFromCart() method.
    }

    public function UpdateCart($request)
    {
        // TODO: Implement UpdateCart() method.
    }

    public function userCart()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        return $this->apiResponse(200, 'user cart', null, $carts);
    }
}
