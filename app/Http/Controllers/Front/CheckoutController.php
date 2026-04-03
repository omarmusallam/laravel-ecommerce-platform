<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderException;
use App\Helpers\Currency;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    protected $currency;
    protected $currencyConverter;

    // public function __construct(Currency $currency, CurrencyConverter $currencyConverter)
    // {
    //     $this->currency = $currency;
    //     $this->currencyConverter = $currencyConverter;
    // }

    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            throw new InvalidOrderException(trans('Cart is empty'));
        }
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'addr.*.first_name' => ['required', 'string', 'max:20'],
            'addr.*.last_name' => ['required', 'string', 'max:20'],
            'addr.*.email' => ['nullable', 'email', 'max:50'],
            'addr.*.phone_number' => ['required', 'digits:10', 'numeric'],
            'addr.*.city' => ['required', 'string', 'max:20'],
        ]);

        $items = $cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {

                // $currencyCode = $this->currency->format(0); // Use default value to access the currency code

                // Convert the total to the selected currency using the CurrencyConverter
                // $totalConverted = $this->currencyConverter->convert('USD', $currencyCode, $cart->total());

                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'stripe',
                    'currency' => 'ILS',
                    'total' => $cart->total(),
                ]);

                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }

            DB::commit();

            //event('order.created', $order, Auth::user());
            event(new OrderCreated($order));

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('orders.payments.create', $order->id);
    }
}