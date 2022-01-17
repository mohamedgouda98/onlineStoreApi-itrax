<?php

namespace App\Rules;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CartProductCountValidation implements Rule
{
    public $productId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cart = Cart::where([ ['user_id', Auth::user()->id], ['product_id', $this->productId] ])->first();
            if($cart)
            {
                $product = Product::find($this->productId);
                if($cart->count + $value <= $product->stock)
                {
                    return true;
                }
                return false;
            }

            return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Over the count of stock';
    }
}
