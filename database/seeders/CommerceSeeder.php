<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommerceSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::query()->take(3)->get();
        $products = Product::query()->active()->take(12)->get();

        foreach ($users as $user) {
            $groupedProducts = $products->random(4)->groupBy('store_id');

            foreach ($groupedProducts as $storeId => $storeProducts) {
                $total = 0;

                $order = Order::query()->create([
                    'store_id' => $storeId,
                    'user_id' => $user->id,
                    'payment_method' => 'stripe',
                    'currency' => 'ILS',
                    'total' => 0,
                ]);

                foreach ($storeProducts as $product) {
                    $quantity = rand(1, 3);
                    $lineTotal = $product->price * $quantity;
                    $total += $lineTotal;

                    OrderItem::query()->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                    ]);
                }

                $order->addresses()->createMany([
                    [
                        'type' => 'billing',
                        'first_name' => $user->name,
                        'last_name' => 'Billing',
                        'email' => $user->email,
                        'phone_number' => $user->phone_number ?? '0599999999',
                        'street_address' => 'Billing Street',
                        'city' => 'Gaza',
                        'postal_code' => '00000',
                        'state' => 'Gaza',
                        'country' => 'PS',
                    ],
                    [
                        'type' => 'shipping',
                        'first_name' => $user->name,
                        'last_name' => 'Shipping',
                        'email' => $user->email,
                        'phone_number' => $user->phone_number ?? '0599999999',
                        'street_address' => 'Shipping Street',
                        'city' => 'Gaza',
                        'postal_code' => '00000',
                        'state' => 'Gaza',
                        'country' => 'PS',
                    ],
                ]);

                $order->update(['total' => $total]);

                Payment::query()->create([
                    'order_id' => $order->id,
                    'amount' => $total,
                    'currency' => 'ILS',
                    'method' => 'stripe',
                    'status' => 'completed',
                    'transaction_id' => 'txn_' . Str::lower(Str::random(16)),
                    'transaction_data' => json_encode(['seeded' => true]),
                ]);

                Delivery::query()->create([
                    'order_id' => $order->id,
                    'current_location' => $this->seedLocation(),
                    'status' => 'pending',
                ]);
            }
        }

        foreach ($products->take(5) as $product) {
            Cart::query()->create([
                'id' => (string) Str::uuid(),
                'cookie_id' => (string) Str::uuid(),
                'user_id' => $users->first()?->id,
                'admin_id' => null,
                'product_id' => $product->id,
                'quantity' => rand(1, 2),
                'options' => json_encode(['seeded' => true]),
            ]);
        }
    }

    protected function seedLocation()
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return '34.4667,31.5000';
        }

        return DB::raw("POINT(34.4667, 31.5000)");
    }
}
