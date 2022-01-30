<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory(5)->create()->each(function($user){
            Product::factory(4)->create()->each(function($product) use($user){
                Cart::factory()->create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'count' => ($product->stock - 5)
                ]);
            });
        });


        $this->call([
           RolePermissionSeeder::class
        ]);

        // User::factory(10)->create();
        // Product::factory(10)->create();
        // $this->call([ProductsSeeder::class]);
    }
}
