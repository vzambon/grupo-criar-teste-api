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
            'image_url' => $file->getFilename(),
        ];

        $response = $this->post(route('products.store'), $payload);

        $response->assertCreated();

        Storage::disk('private')->assertExists($response->json()['image_url']);

        $table = (new Product())->getTable();
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, $response->collect()->forget(['created_at', 'updated_at'])->toArray());
    }

    public function test_product_can_be_shown()
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('products.show', ['product' => $product->id]));
        $response->assertOk();

        $table = (new product())->getTable();
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, $product->setHidden(['created_at', 'updated_at'])->toArray());

        $response->assertJson($product->toArray());
    }

    public function test_can_update_product()
    {
        Storage::fake('temp');
        Storage::fake('private');

        $file = UploadedFile::fake()->image('mock_image.png');

        $file_path = 'products/img/'.$file->getFilename();
        Storage::disk('private')->put($file_path, $file);
        Storage::disk('temp')->put($file->getFilename(), $file);

        $product = Product::factory()->state(['image_url' => $file_path])->create();

        $payload = [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'description' => $this->faker->text(),
            'image_url' => $file->getFilename(),
        ];

        $response = $this->put(route('products.update', ['product' => $product->id]), $payload);
        $response->assertOk();

        $this->assertEquals($response->json()['name'], $payload['name']);
        $this->assertEquals($response->json()['price'], $payload['price']);
        $this->assertEquals($response->json()['description'], $payload['description']);
        $this->assertDatabaseHas((new Product())->getTable(), $response->collect()->forget(['created_at', 'updated_at'])->toArray());
        $this->assertDatabaseMissing((new Product())->getTable(), $product->toArray());
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', ['id' => $product->id]));

        $response->assertOk();

        $this->assertDatabaseEmpty((new Product())->getTable());
    }
}
