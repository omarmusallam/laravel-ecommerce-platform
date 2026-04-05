@extends('layouts.dashboard')
@section('title', 'Products')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection
@section('content')
    @push('styles')
        <style>
            .admin-page-header { margin-bottom: 1.25rem; }
            .admin-page-header p { color: #667085; margin: 0.35rem 0 0; }
            .admin-toolbar, .admin-table-card {
                background: #fff; border: 1px solid #e6edf7; border-radius: 20px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
            }
            .admin-toolbar { padding: 1rem; margin-bottom: 1rem; }
            .admin-actions { display: flex; flex-wrap: wrap; gap: .75rem; margin-bottom: 1rem; }
            .admin-actions .btn, .admin-filter-form .btn { border-radius: 999px; }
            .admin-filter-form { display: grid; grid-template-columns: 1.2fr 1fr auto; gap: .75rem; }
            .admin-filter-form .form-control { border-radius: 14px; height: 46px; border-color: #d6e3f2; }
            .admin-table-card { overflow: hidden; }
            .admin-table-card .table { margin: 0; }
            .admin-table-card thead th {
                border: 0; background: #f8fbff; color: #667085; font-size: .78rem; font-weight: 700;
                letter-spacing: .04em; text-transform: uppercase;
            }
            .admin-table-card td { vertical-align: middle; border-color: #edf2f7; }
            .admin-thumb { width: 56px; height: 56px; border-radius: 14px; object-fit: contain; background: #f8fbff; border: 1px solid #e6edf7; padding: 6px; }
            .admin-status-pill {
                display: inline-flex; align-items: center; padding: .35rem .7rem; border-radius: 999px;
                font-size: .75rem; font-weight: 700; text-transform: capitalize;
                background: #eef6ff; color: #1f7aff;
            }
            .admin-row-actions { display: flex; gap: .45rem; justify-content: flex-end; }
            .admin-row-actions .btn { border-radius: 12px; }
            .admin-table-footer { padding: 1rem 1.25rem; border-top: 1px solid #edf2f7; background: #fff; }
            @media (max-width: 991.98px) { .admin-filter-form { grid-template-columns: 1fr; } }
        </style>
    @endpush

    <div class="admin-page-header">
        <h2 class="h4 mb-0">Products</h2>
        <p>Manage your product catalog, review status, and move quickly between editing, importing, and exporting.</p>
    </div>

    <div class="admin-toolbar">
        <div class="admin-actions">
            @if (Auth::user()->can('products.create'))
                <a title="Create product" href="{{ route('dashboard.products.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> New Product</a>
            @endif
            <a title="Export products" href="{{ route('dashboard.products.export', request()->query()) }}" class="btn btn-outline-dark"><i class="fas fa-download mr-1"></i> Export</a>
            <a title="Import products" href="{{ route('dashboard.products.import.view') }}" class="btn btn-outline-success"><i class="fas fa-upload mr-1"></i> Import</a>
        </div>

    <x-alert type="success" />
    <x-alert type="info" />

        <form action="{{ URL::current() }}" method="get" class="admin-filter-form">
            <x-form.input name="name" placeholder="Search by product name" :value="request('name')" />
            <select name="category_id" class="form-control">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary"><i class="fas fa-search mr-1"></i> Filter</button>
        </form>
    </div>

    <div class="admin-table-card">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Store</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count())
                    @foreach ($products as $product)
                        <tr>
                            <td><img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="admin-thumb"></td>
                            <td>#{{ $product->id }}</td>
                            <td><a href="{{ route('dashboard.products.edit', $product->id) }}" class="font-weight-bold text-dark">{{ $product->name }}</a></td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->store->name }}</td>
                            <td><span class="admin-status-pill">{{ $product->status }}</span></td>
                            <td>{{ $product->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="admin-row-actions">
                                    @can('products.update')
                                        <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('products.delete')
                                        <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center py-4">No products defined.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="admin-table-footer">
            {{ $products->withQueryString()->appends(['search' => 1])->links() }}
        </div>
    </div>
@endsection
