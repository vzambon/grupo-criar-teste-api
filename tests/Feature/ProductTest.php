<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Products\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_list_products()
    {
        Product::factory(5)->create();
        
        $response = $this->get(route('products.index'));

        $response->assertOk()->assertJsonCount(5);
    }

    public function test_can_create_product()
    {
        Storage::fake('temp');
        Storage::fake('private');

        $file = UploadedFile::fake()->image('mock_image.png');

        Storage::disk('temp')->put($file->getFilename(), $file);

        $payload = [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'description' => $this->faker->text(),
            'image_url' => $file->getFilename()
        ];

        $response = $this->post(route('products.store'), $payload);

        $response->assertCreated();

        Storage::disk('private')->assertExists($response->json()['image_url']);

        $table = (new Product())->getTable();
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, $response->json());
    }

    public function test_product_can_be_shown()
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('products.show', ['product' => $product->id]));
        $response->assertOk();

        $table = (new product())->getTable();
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, $product->toArray());

        $response->assertJson($product->toArray());
    }

    public function test_can_update_product()
    {
        
    }

    public function test_can_delete_product()
    {
        //...
    }
}
