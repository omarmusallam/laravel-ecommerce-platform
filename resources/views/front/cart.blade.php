<x-front-layout title="{{ __('Cart') }}">
    @push('styles')
        <style>
            .notification-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
            }

            .notification {
                padding: 10px;
                margin-bottom: 10px;
                color: #fff;
                font-weight: bold;
                border-radius: 4px;
            }

            .success {
                background-color: #0167F3;
            }

            .error {
                background-color: #f44336;
            }
        </style>
    @endpush
    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">{{ __('Cart') }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                            <li><a href="{{ route('list-products.index') }}">{{ __('Shop') }}</a></li>
                            <li>{{ __('Cart') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="cart-list-head">
                <x-alert type="success" />
                <!-- Cart List Title -->
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12">

                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>{{ __('Product Name') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('Quantity') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('Price') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('Subtotal') }}</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>{{ __('Remove') }}</p>
                        </div>
                    </div>
                </div>
                <!-- End Cart List Title -->
                <div id="notification-container" class="notification-container"></div>
                @foreach ($cart->get() as $item)
                    <!-- Cart Single List list -->
                    <div class="cart-single-list" id="{{ $item->id }}">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a href="{{ route('products.show', $item->product->slug) }}">
                                    <img src="{{ $item->product->image_url }}" alt="#"></a>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <h5 class="product-name"><a href="{{ route('products.show', $item->product->slug) }}">
                                        {{ $item->product->name }}</a></h5>
                                <p class="product-des">
                                    <span><em>{{ __('Brand:') }}</em> {{ $item->product->category->name }}</span>
                                    @if ($item->product->sale_percent)
                                        <span class=""><em>{{ __('Discount:') }}
                                            </em>-{{ $item->product->sale_percent }}%</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <div class="count-input">
                                    <input style="width: 100px" type="number" min="1" max="9"
                                        class="form-control item-quantity" data-id="{{ $item->id }}"
                                        value="{{ $item->quantity }}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ Currency::format($item->product->price) }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p id="item-total-{{ $item->id }}">
                                    {{ Currency::format($item->quantity * $item->product->price) }}</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <a class="remove-item" data-id="{{ $item->id }}" href="javascript:void(0)"><i
                                        class="lni lni-close"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- End Single List list -->
                @endforeach


            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                {{-- <div class="left">
                                    <div class="coupon">
                                        <form action="#" target="_blank">
                                            <input name="Coupon" placeholder="{{ __('Enter Your Coupon') }}">
                                            <div class="button">
                                                <button type="button" class="btn">{{ __('Apply Coupon') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        <li>{{ __('Cart Subtotal') }}<span
                                                id="cart-subtotal">{{ Currency::format($cart->total()) }}</span>
                                        </li>
                                        <li>{{ __('Shipping') }}<span>{{ __('Free') }}</span></li>
                                        <li>{{ __('Tax') }}<span>{{ Currency::format(00.0) }}</span></li>
                                        <li class="last">
                                            {{ __('You Pay') }}<span
                                                id="you-pay">{{ Currency::format($cart->total()) }}</span>
                                        </li>
                                    </ul>
                                    <div class="button">
                                        <a href="{{ route('checkout') }}" class="btn">{{ __('Checkout') }}</a>
                                        <a href="{{ route('list-products.index') }}"
                                            class="btn btn-alt">{{ __('Continue shopping') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->

    @push('scripts')
        <script>
            const csrf_token = "{{ csrf_token() }}";
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="{{ asset('js/cart.js') }}"></script>
    @endpush
</x-front-layout>
