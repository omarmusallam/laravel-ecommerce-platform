@extends('layouts.dashboard')
@section('title', 'Products')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection
@section('content')
    <div class="mb-5">
        @if (Auth::user()->can('products.create'))
            <a title="Create product" href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-outline-primary mr-2"><i class="fas fa-plus"></i></a>
        @endif
        <a title="Export products" href="{{ route('dashboard.products.export', request()->query()) }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-download"></i></a>
        <a title="Import products" href="{{ route('dashboard.products.import.view') }}" class="btn btn-sm btn-outline-success"><i class="fas fa-upload"></i></a>
    </div>

    <x-alert type="success" />
    <x-alert type="info" />

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="category_id" class="form-control mx-2">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary mx-2">
            <i class="fas fa-search"></i>
        </button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Store</th>
                <th>Status</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @if ($products->count())
                @foreach ($products as $product)
                    <tr>
                        <td><img src="{{ $product->image_url }}" alt="" height="50px"></td>
                        <td>{{ $product->id }}</td>
                        <td><a href="{{ route('dashboard.products.edit', $product->id) }}">{{ $product->name }}</a></td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->store->name }}</td>
                        <td>{{ $product->status }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>
                            @can('products.update')
                                <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                    class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                            @endcan
                        </td>
                        <td>
                            @can('products.delete')
                                <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9">No products defined.</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $products->withQueryString()->appends(['search' => 1])->links() }}
@endsection
