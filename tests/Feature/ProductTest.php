<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User\User;
use App\Models\Product\Product;
use App\Models\Category\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_product_list(){
        $user = User::factory()->create();
        
          $this->actingAs($user ,'sanctum');


        $category= Category::factory()->count(5)->create();
         Product::factory()->count(10)->create(['category_id'=> $category->random()->id]);

       $response = $this->getJson('/api/products')->assertStatus(200)->assertJson(['success' => true])
        ->assertJsonStructure([
            'data'=>[
                '*'=>['title',
            'description' ,
            'quantity' ,
            'price' ,
            'discount_price' ,
            'status',
             'category' =>[
                'id',
                'slug'
             ]
            ]
            ]
        ]);
        // $response->dump();

    }
    public function test_seller_can_create_product(){
        $seller = User::factory()->create([
            'role' =>'seller'
        ]);
        $this->actingAs($seller,'sanctum');
        $category= Category::factory()->count(5)->create();
        
      $product= Product::factory()->count(10)->create(['category_id'=> $category->random()->id,'user_id'=>$seller ->id]);

        $this->postJson('/api/product', $product->toArray())
        ->assertStatus(201)
        ->assertJson(['success' => true])
        ->assertJsonStructure([
                '*'=>['title',
            'description' ,
            'quantity' ,
            'price' ,
            'discount_price' ,
            'status',
             'category' =>[
                'id',
                'slug'
             ]
            ]
             ]);

        // $response = $this->postJson('/api/products',$product->toArray());
        // $product->dump();

    }
}
