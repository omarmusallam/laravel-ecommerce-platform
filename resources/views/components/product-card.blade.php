<!-- Start Single Product -->
<div class="single-product" id="{{ $product->id }}">
    <div class="product-image">
        <img src="{{ $product->thumb_url }}" alt="#">
        @if ($product->sale_percent)
            <span class="sale-tag">-{{ $product->sale_percent }}%</span>
        @endif
        @if ($product->featured)
            <span class="new-tag">مميز</span>
        @endif
        <div class="button">
            <a href="{{ route('products.show', $product->slug) }}" class="btn add-to-cart"
                data-id="{{ $product->id }}"><i class="lni lni-cart"></i> عرض التفاصيل</a>
        </div>
    </div>
    <div class="product-info">
        <span class="category">{{ $product->category->name }}</span>
        <h4 class="title">
            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
        </h4>
        <ul class="review">
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star"></i></li>
            <li><span>4.0 تقييم</span></li>
        </ul>
        <div class="price">
            <span>{{ App\Helpers\Currency::format($product->price) }}</span>
            @if ($product->compare_price)
                <span class="discount-price">{{ App\Helpers\Currency::format($product->compare_price) }}</span>
            @endif
        </div>
    </div>
</div>
{{-- @push('scripts') --}}
    {{-- <script>
        const csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    {{-- <script src="{{ asset('build/assets/js/cart.js') }}"></script> --}}
{{-- @endpush --}}
{{-- @vite('resources/js/cart.js') --}}
<!-- End Single Product -->
