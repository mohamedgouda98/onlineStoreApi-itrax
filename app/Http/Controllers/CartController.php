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

    public function deleteFromCart(Request $request)
    {
        return $this->cartInterface->deleteFromCart($request);
    }

    public function updateCart(Request $request)
    {
        return $this->cartInterface->updateCart($request);
    }

    public function deleteCart()
    {
        return $this->cartInterface->deleteCart();
    }

    public function getAllCarts()
    {
        return $this->cartInterface->getAllCarts();
    }
}
