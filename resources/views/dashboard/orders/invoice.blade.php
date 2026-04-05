<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>#{{ $order->number }}</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap");

        @media print {

            html,
            body {
                width: 210mm;
                margin: 0;
                padding: 0;
                margin-top: 20px;
            }

            @page {
                size: A4;
                margin-top: 30px;
            }

            @page :header {
                display: none;
            }

            @page :footer {
                display: none;
            }
        }

        body {
            font-family: "Roboto", sans-serif;
        }

        .all {
            margin: 30px;
            border: 2px solid rgb(179, 24, 24);
        }

        .image {
            margin: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .invoice {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .tr-one {
            background-color: rgb(179, 24, 24);
            color: white;
        }

        .first-table {
            padding: 10px;
            margin: 30px;
            text-align: left;
            display: flex;
            justify-content: center;
            border: 3px solid rgb(179, 24, 24);
            border-radius: 5px;
            font-weight: bold;
            border-bottom: 3px dashed rgb(179, 24, 24);
            border-top: 3px solid rgb(179, 24, 24);
        }

        td {
            width: 170px;
        }

        h2 {
            text-align: center;
        }

        .second-table {
            display: flex;
            justify-content: center;
            margin: 20px;
            border-collapse: collapse;
            border: 3px solid rgb(179, 24, 24);
        }

        .second-table td {
            text-align: center;
            border: 1px solid white;
        }

        .second-table tr {
            border: 1px solid rgb(110, 107, 107);
        }

        .third-table {
            margin: 40px;
            text-align: left;
            display: flex;
            justify-content: center;
            font-weight: bold;
        }

        .container {
            display: flex;
            justify-content: center;
            border: 2px solid rgb(179, 24, 24);
            margin: 30px;
            margin-left: 50px;
            width: 500px;
            border-radius: 20px;
        }

        .left,
        .right {
            text-align: center;
            border-right: 1px solid rgb(179, 24, 24);
            margin: 18px;
        }

        .left2,
        .right2 {
            text-align: center;
        }

        .left {
            margin-right: 60px;
        }

        .container2 {
            display: flex;
            justify-content: center;
            margin: 30px;
        }

        .font1 {
            font-weight: 600;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div id="printable-content">
        <div class="all invoice">
            <header class="image">
                <img src="{{ $settings->website_logo_url ?: asset('assets/images/logo/logo.jpg') }}" alt="Store logo" width="400">
            </header>

            <div class="first-table">
                <table dir="ltr" class="table1">
                    <tr class="tr-one">
                        <th colspan="4" style="padding: 8px">Customer Details</th>
                    </tr>
                    <tr>
                        <td>Invoice Number:</td>
                        <td style="color: rgb(179, 24, 24);">#{{ $order->number }}</td>
                        <td>Date:</td>
                        <td>{{ $order->created_at->toDateString() }}</td>
                    </tr>
                    <tr>
                        <td>Customer Name:</td>
                        <td>{{ $order->billingAddress->name }}</td>
                        <td>Address:</td>
                        <td>{{ $order->billingAddress->city }} - {{ $order->billingAddress->street_address }}</td>
                    </tr>
                    <tr>
                        <td>Phone Number:</td>
                        <td>{{ $order->billingAddress->phone_number }}</td>
                        <td>Email:</td>
                        <td>{{ $order->billingAddress->email }}</td>
                    </tr>
                </table>
            </div>

            <h2>Order Details</h2>

            <div class="second-table">
                <table dir="ltr">
                    <tr class="tr-one">
                        <td class="font1">#</td>
                        <td class="font1">Product Name</td>
                        <td class="font1">Quantity</td>
                        <td class="font1">Price</td>
                    </tr>
                    @foreach ($order->items as $item)
                        <tr>
                            <td><img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" width="70" height="70"></td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ App\Helpers\Currency::format($item->price, $order->currency) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>#</td>
                        <td>Delivery Services</td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>{{ App\Helpers\Currency::format(0, $order->currency) }}</td>
                    </tr>
                </table>
            </div>

            <div class="third-table">
                <table dir="ltr">
                    <tr>
                        <td>Payment Method:</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>Stamp:</td>
                        <td>
                            @if ($settings->invoice_stamp_url)
                                <img src="{{ $settings->invoice_stamp_url }}" alt="Invoice stamp" width="25" height="30">
                            @else
                                <img src="{{ asset('assets/images/icon.png') }}" alt="Invoice stamp" width="25" height="30">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Total Amount:</td>
                        <td style="color: rgb(179, 24, 24)">
                            {{ App\Helpers\Currency::format($order->items->sum(fn ($product) => $product->price * $product->quantity), $order->currency) }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="container">
                <div class="left" dir="ltr">
                    <p>I have received the above device in good condition with all collected accessories.</p>
                </div>
                <div class="right" dir="ltr">
                    <p style="padding: 18px 20px 0">Customer signature and approval of the warranty terms and complimentary delivery service.</p>
                </div>
            </div>

            <div class="container2">
                <div class="left2" style="text-align: left">
                    <p>{{ $settings->phone }}</p>
                </div>
                <div class="right2" style="margin-left: 140px">
                    @if ($settings->qr_code_url)
                        <img src="{{ $settings->qr_code_url }}" width="60" height="60" alt="QR code">
                    @endif
                    <p>{{ $settings->email }}</p>
                </div>
            </div>

        </div>
    </div>
    <script>
        window.onload = function() {
            var printableContent = document.getElementById('printable-content');
            printableContent.style.display = 'block';

            window.print();
        };
    </script>
</body>

</html>
