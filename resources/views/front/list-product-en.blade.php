<x-front-layout title="Products">
    @push('styles')
        <style>
            .catalog-shell {
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 22%, #f8fafc 100%);
            }

            .catalog-header {
                padding: 24px 0 10px;
            }

            .catalog-header h1 {
                margin-bottom: 10px;
            }

            .catalog-header p {
                color: #667085;
                margin-bottom: 0;
            }

            .catalog-sidebar,
            .catalog-toolbar {
                background: #fff;
                border: 1px solid #e8eef7;
                border-radius: 24px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
            }

            .catalog-sidebar {
                padding: 24px;
            }

            .catalog-sidebar .single-widget {
                margin-bottom: 28px;
            }

            .catalog-sidebar .single-widget:last-child {
                margin-bottom: 0;
            }

            .catalog-sidebar h3 {
                font-size: 18px;
                margin-bottom: 16px;
            }

            .catalog-sidebar .search form {
                display: grid;
                gap: 12px;
            }

            .catalog-sidebar .search button {
                height: 46px;
                border: 0;
                border-radius: 14px;
                background: #0167f3;
                color: #fff;
            }

            .catalog-sidebar .list {
                margin: 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 12px;
            }

            .catalog-sidebar .list li {
                display: flex;
                justify-content: space-between;
                gap: 10px;
                color: #667085;
            }

            .catalog-sidebar .list a {
                color: #081828;
                font-weight: 600;
            }

            .catalog-toolbar {
                padding: 18px 22px;
                margin-bottom: 28px;
            }

            .catalog-results {
                color: #667085;
                margin-bottom: 0;
            }

            .catalog-pill {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 14px;
                border-radius: 999px;
                background: #edf4ff;
                color: #0167f3;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                margin-bottom: 12px;
            }

            @media (max-width: 991.98px) {
                .catalog-sidebar {
                    margin-bottom: 24px;
                }
            }
        </style>
    @endpush

    <section class="catalog-shell section">
        <div class="container">
            <div class="catalog-header">
                <span class="catalog-pill">ShopGrids Store</span>
                <h1>Products</h1>
                <p>Browse premium electronics, practical accessories, and everyday best-sellers with a cleaner shopping flow.</p>
            </div>

            <div class="row">
                <div class="col-lg-3 col-12">
                    <aside class="catalog-sidebar">
                        <div class="single-widget search">
                            <h3>Search Products</h3>
                            <form action="{{ URL::current() }}" method="get">
                                <x-form.input name="name" placeholder="Product name or category" :value="request('name')" />
                                <button type="submit"><i class="lni lni-search-alt"></i> Search</button>
                            </form>
                        </div>

                        <div class="single-widget">
                            <h3>Categories</h3>
                            <ul class="list">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('list-products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                        <span>{{ $category->products_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>
                </div>

                <div class="col-lg-9 col-12">
                    <div class="catalog-toolbar">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div>
                                <strong>Newest products</strong>
                                <p class="catalog-results">
                                    Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} products
                                </p>
                            </div>
                            <span class="catalog-pill mb-0"><i class="lni lni-grid-alt"></i> Grid View</span>
                        </div>
                    </div>

                    <div class="row product-card-grid">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6 col-12 product-card-column">
                                <x-product-card :product="$product" />
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5">
                        {{ $products->withQueryString()->links('pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-front-layout>
