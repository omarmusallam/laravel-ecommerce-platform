<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SiteNavigationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    public function test_public_pages_render_successfully(): void
    {
        $product = Product::query()->active()->firstOrFail();
        $order = Order::query()->firstOrFail();

        $this->get('/')->assertOk();
        $this->get('/products/' . $product->slug)->assertOk();
        $this->get('/list-products')->assertOk();
        $this->get('/list-products?category=' . $product->category->slug)->assertOk();
        $this->get('/cart')->assertOk();
        $this->get('/about-us')->assertOk();
        $this->get('/faq')->assertOk();
        $this->get('/contact-us')->assertOk();
        $this->get('/login')->assertOk();
        $this->get('/register')->assertOk();
        $this->get('/orders/' . $order->id)->assertOk();
    }

    public function test_protected_pages_redirect_guests_cleanly(): void
    {
        $this->get('/checkout')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    public function test_contact_form_submits_successfully(): void
    {
        Mail::fake();

        $response = $this->post('/contact-us', [
            'name' => 'Smoke Tester',
            'subject' => 'Navigation check',
            'email' => 'tester@example.com',
            'phone' => '0591234567',
            'message' => 'Testing contact form flow.',
        ]);

        $response->assertOk();
    }
}
