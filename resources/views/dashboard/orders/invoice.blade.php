<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
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

        hr {
            border: 1px solid rgb(179, 24, 24);
        }

        .tr-one {
            background-color: rgb(179, 24, 24);
            color: white;
        }

        .first-table {
            padding: 10px;
            margin: 30px;
            text-align: right;
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
            display: flex;
            justify-content: center;
            border-collapse: collapse;
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
            text-align: right;
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

        .bord {
            border-top: 3px solid rgb(188, 186, 186);
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
                <img src="{{ asset('assets/images/logo/logo.jpg') }}" alt="Header Image" width="400px">
            </header>

            <div class="first-table">
                <table dir="rtl" claa="table1">
                    <tr class="tr-one">
                        <th colspan="4" style="padding: 8px">بيانات العميل</th>
                    </tr>
                    <tr>
                        <td>رقم الفاتورة :</td>
                        <td style="color: rgb(179, 24, 24);">#{{ $order->number }}</td>
                        <td>التاريخ :</td>
                        <td>{{ $order->created_at->toDateString() }}</td>
                    </tr>
                    <tr>
                        <td>اسم العميل :</td>
                        <td>{{ $order->billingAddress->name }}</td>
                        <td>العنوان :</td>
                        <td>{{ $order->billingAddress->city }} -
                            {{ $order->billingAddress->street_address }}</td>
                    </tr>
                    <tr>
                        <td>رقم الهاتف :</td>
                        <td>{{ $order->billingAddress->phone_number }}</td>
                        <td>البريد :</td>
                        <td>{{ $order->billingAddress->email }}</td>
                    </tr>
                </table>
            </div>
            <h2>تفاصيل الطلب</h2>

            <div class="second-table">
                <table dir="rtl">
                    <tr class="tr-one">
                        <td class="font1">#</td>
                        <td class="font1">اسم المنتج</td>
                        <td class="font1">الكمية</td>
                        <td class="font1">السعر</td>
                    </tr>
                    @foreach ($order->items as $item)
                        <tr>
                            <td> <img src="{{ $item->product->image_url }}" alt="img" width="70px"
                                    height="70px">
                            </td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->price }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>#</td>
                        <td>خدمات التوصيل</td>
                        <td> {{ $order->items->sum('quantity') }}</td>
                        <td>0</td>
                    </tr>
                </table>
            </div>

            <div class="third-table">
                <table dir="rtl">
                    <tr>
                        <td>طريقة الدفع :</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>الختم :</td>
                        <td><img src="{{ asset('assets/images/icon.png') }}" alt="img" width="25px"
                                height="30px"></td>
                    </tr>
                    <tr>
                        <td>المبلغ الكلي :</td>
                        <td style="color: rgb(179, 24, 24)">
                            {{ $order->items->sum(function ($product) {return $product->price * $product->quantity;}) }}
                        </td>
                        {{-- <td>الختم :</td>
                        <td><img src="{{ asset('assets/images/icon.png') }}" alt="img" width="25px"
                                height="30px"></td> --}}
                    </tr>
                </table>
            </div>

            <div class="container">
                <div class="left" dir="ltr">
                    <p>Thave recived the above devive in good
                        condition with all collected
                        accessorites</p>
                </div>
                <div class="rigth" dir="rtl">
                    <p style="padding-right: 20px; padding-top: 18px">توقيع العميل و موافقته على أنظمة الضمان و خدمة
                        التوصيل المجاني</p>
                </div>
            </div>


            <div class="container2">
                <div class="left2" style="text-align: left">
                    <p>{{ $settings->phone }}</p>
                </div>
                <div class="rigth2" style="margin-left: 140px">
                    <img src="{{ $settings->qr_code_url }}" width="60" height="60" alt="pin Image">
                    <p>{{ $settings->email }}</p>
                </div>  

            </div>

        </div>
    </div>
    <script>
        window.onload = function() {
            var printableContent = document.getElementById("printable-content");
            printableContent.style.display = "block";

            window.print();
        };
    </script>
</body>

</html>
