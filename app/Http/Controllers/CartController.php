<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CartInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $cartInterface;
    public function __construct(CartInterface $cartInterface)
    {
        $this->cartInterface = $cartInterface;
    }

    public function addToCart(Request $request)
    {
        return $this->cartInterface->addToCart($request);
    }

    public function userCart()
    {
        return $this->cartInterface->userCart();
    }
}
