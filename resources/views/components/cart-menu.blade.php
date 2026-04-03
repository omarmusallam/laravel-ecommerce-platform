<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        <span class="total-items" id="cart-items">{{ $items2->count() }}</span>
    </a>
    <!-- Shopping Item -->
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span><span id="cart-items2">{{ $items2->count() }}</span> {{ __('Items') }}</span>
            <a href="{{ route('cart.index') }}">{{ __('View Cart') }}</a>
        </div>
        <ul class="shopping-list" id="cart-list">
            @foreach ($items as $item)
                <li id="{{ $item->id }}">
                    <a href="javascript:void(0)" class="remove remove-item" title="Remove this item"
                        data-id="{{ $item->id }}"><i class="lni lni-close"></i></a>
                    <div class="cart-img-head">
                        <a class="cart-img" href="{{ route('products.show', $item->product->slug) }}"><img
                                src="{{ $item->product->image_url }}" alt="#"></a>
                    </div>
                    <div class="content">
                        <h4><a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                        </h4>
                        <p class="quantity">{{ $item->quantity }}x - <span
                                class="amount">{{ Currency::format($item->product->price) }}</span></p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="bottom">
            <div class="total">
                <span>{{ __('Total') }}</span>
                <span class="total-amount">{{ Currency::format($total) }}</span>
            </div>
            <div class="button">
                <a href="{{ route('checkout') }}" class="btn animate">{{ __('Checkout') }}</a>
            </div>
        </div>
    </div>
    <!--/ End Shopping Item -->
</div>

<script>
    const csrf_token = "{{ csrf_token() }}";
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="{{ asset('js/cart.js') }}"></script>
