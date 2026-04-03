<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DashboardProductImagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_product_with_main_image_and_gallery(): void
    {
        Storage::fake('public');

        $admin = Admin::factory()->create([
            'super_admin' => true,
        ]);
        $store = Store::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($admin, 'admin')->post(route('dashboard.products.store'), [
            'name' => 'MacBook Pro 16',
            'store_id' => $store->id,
            'category_id' => $category->id,
            'description' => 'High-end laptop for professional work.',
            'price' => 2499.99,
            'compare_price' => 2699.99,
            'quantity' => 8,
            'status' => 'active',
            'image' => UploadedFile::fake()->image('macbook.jpg', 1200, 800),
            'gallery' => [
                UploadedFile::fake()->image('macbook-1.jpg', 1200, 800),
                UploadedFile::fake()->image('macbook-2.jpg', 1200, 800),
            ],
        ]);

        $response->assertRedirect(route('dashboard.products.index'));

        $product = Product::query()->where('name', 'MacBook Pro 16')->firstOrFail();

        $this->assertNotNull($product->image);
        $this->assertStringContainsString('/storage/uploads/', $product->image_url);
        Storage::disk('public')->assertExists($product->image);
        $this->assertCount(2, $product->images);
        Storage::disk('public')->assertExists($product->images[0]->image);
        Storage::disk('public')->assertExists($product->images[1]->image);
    }

    public function test_admin_can_update_product_and_display_the_new_main_image_correctly(): void
    {
        Storage::fake('public');

        $admin = Admin::factory()->create([
            'super_admin' => true,
        ]);
        $store = Store::factory()->create();
        $category = Category::factory()->create();

        $oldImage = UploadedFile::fake()->image('old-laptop.jpg', 1200, 800)->store('uploads', 'public');

        $product = Product::factory()->create([
            'store_id' => $store->id,
            'category_id' => $category->id,
            'image' => $oldImage,
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin, 'admin')->post(route('dashboard.products.update', $product), [
            '_method' => 'PUT',
            'name' => 'Updated Gaming Laptop',
            'store_id' => $store->id,
            'category_id' => $category->id,
            'description' => 'Updated description',
            'price' => 1799.99,
            'compare_price' => 1999.99,
            'quantity' => 5,
            'status' => 'active',
            'image' => UploadedFile::fake()->image('new-laptop.jpg', 1200, 800),
            'gallery' => [
                UploadedFile::fake()->image('gallery-1.jpg', 1200, 800),
            ],
        ]);

        $response->assertRedirect(route('dashboard.products.index'));

        $product->refresh();

        $this->assertSame('Updated Gaming Laptop', $product->name);
        $this->assertNotSame($oldImage, $product->image);
        $this->assertStringContainsString('/storage/uploads/', $product->image_url);
        Storage::disk('public')->assertExists($product->image);
        $this->assertCount(1, $product->images);
        $this->assertStringContainsString('/storage/uploads/', $product->images->first()->image_url);
    }
}
