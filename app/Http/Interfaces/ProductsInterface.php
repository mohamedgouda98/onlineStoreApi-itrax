<?php

namespace App\Http\Interfaces;

interface ProductsInterface
{
    public function products();
    public function create($request);
    public function update($request);
    public function delete($request);
    public function archive();
}
