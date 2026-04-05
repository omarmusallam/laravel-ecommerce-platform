<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProjectHardeningTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    public function test_storefront_defaults_to_english_ltr_and_usd(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('lang="en"', false);
        $response->assertSee('dir="ltr"', false);
        $response->assertSee('English Storefront');
        $response->assertSee('$ USD');
    }

    public function test_storage_route_blocks_path_traversal(): void
    {
        $this->get('/storage/../.env')->assertNotFound();
    }

    public function test_send_sms_route_is_not_publicly_accessible(): void
    {
        $response = $this->get('/send-sms');

        $this->assertTrue(in_array($response->getStatusCode(), [302, 401, 403], true));
    }

    public function test_checkout_rejects_cart_items_from_multiple_stores(): void
    {
        $user = User::query()->where('email', 'user@example.com')->firstOrFail();
        $firstProduct = Product::query()->active()->firstOrFail();

        $secondStore = Store::query()->create([
            'name' => 'Second Store',
            'slug' => 'second-store',
            'description' => 'Secondary storefront for checkout validation.',
            'status' => 'active',
        ]);

        $secondProduct = Product::query()->create([
            'name' => 'Validation Product',
            'slug' => 'validation-product',
            'description' => 'Used to validate multi-store checkout protection.',
            'image' => $firstProduct->image,
            'category_id' => $firstProduct->category_id,
            'store_id' => $secondStore->id,
            'price' => 120,
            'compare_price' => 150,
            'quantity' => 10,
            'featured' => false,
            'status' => 'active',
        ]);

        $cookieId = (string) Str::uuid();
        $now = now();

        DB::table('carts')->insert([
            [
                'id' => (string) Str::uuid(),
                'cookie_id' => $cookieId,
                'user_id' => $user->id,
                'admin_id' => null,
                'product_id' => $firstProduct->id,
                'quantity' => 1,
                'options' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'cookie_id' => $cookieId,
                'user_id' => $user->id,
                'admin_id' => null,
                'product_id' => $secondProduct->id,
                'quantity' => 1,
                'options' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $payload = [
            'addr' => [
                'billing' => [
                    'first_name' => 'Demo',
                    'last_name' => 'Customer',
                    'email' => 'user@example.com',
                    'phone_number' => '0591234567',
                    'street_address' => '123 Main Street',
                    'city' => 'Washington',
                    'postal_code' => '20001',
                    'state' => 'DC',
                    'country' => 'US',
                ],
                'shipping' => [
                    'first_name' => 'Demo',
                    'last_name' => 'Customer',
                    'email' => 'user@example.com',
                    'phone_number' => '0591234567',
                    'street_address' => '123 Main Street',
                    'city' => 'Washington',
                    'postal_code' => '20001',
                    'state' => 'DC',
                    'country' => 'US',
                ],
            ],
        ];

        $this->actingAs($user)
            ->withCookie('cart_id', $cookieId)
            ->post('/checkout', $payload)
            ->assertRedirect('/cart')
            ->assertSessionHasErrors([
                'cart' => 'Please complete checkout with items from one store at a time.',
            ]);
    }
}
