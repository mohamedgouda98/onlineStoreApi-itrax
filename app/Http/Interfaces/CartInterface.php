<?php

namespace App\Http\Interfaces;

interface CartInterface
{
    public function addToCart($request);
    public function deleteFromCart($request);
    public function updateCart($request);
    public function userCart();
    public function deleteCart();
    public function getAllCarts();
}
