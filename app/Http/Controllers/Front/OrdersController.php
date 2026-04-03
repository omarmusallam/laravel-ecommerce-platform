<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrdersController extends Controller
{
    public function show(Order $order)
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            $delivery = $order->delivery()->first();

            if ($delivery && $delivery->current_location) {
                [$lng, $lat] = array_pad(explode(',', $delivery->current_location), 2, null);
                $delivery->lat = $lat !== null ? trim($lat) : null;
                $delivery->lng = $lng !== null ? trim($lng) : null;
            }
        } else {
            $delivery = $order->delivery()->select([
                'id',
                'order_id',
                'status',
                DB::raw("ST_Y(current_location) AS lat"),
                DB::raw("ST_X(current_location) AS lng"),
            ])->first();
        }

        return view('front.orders.show', [
            'order' => $order,
            'delivery' => $delivery,
        ]);
    }
}
