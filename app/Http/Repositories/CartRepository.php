<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\CartInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Cart;
use App\Models\User;
use App\Rules\CartExists;
use App\Rules\ProductCountRule;
use App\Rules\ProductExistInCartRule;
use App\Rules\ProductExists;
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
       }

       else
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
        $validations = Validator::make($request->all(),[
                'product_id' => ['required',
                    new CartExists(),
                    new ProductExists(),
                    new ProductExistInCartRule()
            ],
        ]);

        if($validations->fails())
        {
            return $this->apiResponse(400, 'validation error', $validations->errors());
        }

        $cart = Cart::where([ ['user_id', Auth::user()->id], ['product_id', $request->product_id] ])->first();

        $cart->delete();

        return $this->apiResponse(200, 'The product was deleted from cart');
    }

    public function updateCart($request)
    {
        $validations = Validator::make($request->all(),[
            'product_id' => ['required',
                    new CartExists(),
                    new ProductExists(),
                    new ProductExistInCartRule()
                ],
            'count' => ['required', new ProductCountRule($request->product_id)]
        ]);

        if($validations->fails())
        {
            return $this->apiResponse(400, 'validation error', $validations->errors());
        }

        $cart = Cart::where([ ['user_id', Auth::user()->id], ['product_id', $request->product_id] ])->first();

        $cart->update([
            'count' => $request->count
        ]);

        return $this->apiResponse(200, 'Cart was updated');
    }

    public function userCart()
    {
        // $carts = Cart::where('user_id', Auth::user()->id)->get();
        $carts = User::with(['carts.product'])->where([['id',Auth::user()->id]])->get();
        return $this->apiResponse(200, 'user cart', null, $carts);
    }

    public function deleteCart()
    {
        if(Auth::check())
        {
            Cart::where('user_id', Auth::user()->id)->delete();
        }
        return $this->apiResponse(200, 'Cart was deleted');
    }

    public function getAllCarts()
    {
        $carts = Cart::with(['user','product'])->get();

        return $this->apiResponse(200, 'All carts', null, $carts);
    }
}