@extends('layouts.dashboard')
@section('title', $store->name)
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Stores</li>
    <li class="breadcrumb-item active">{{ $store->name }}</li>

@endsection
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Category</th>
                <th>Desc</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @php
                $products = $store
                    ->products()
                    ->with('category')
                    ->latest()
                    ->paginate(10);
            @endphp
            @if ($store->products->count())
                @foreach ($products as $product)
                    <tr>
                        <td><img src="{{ $product->image_url }}" alt="" height="50px"></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->status }}</td>
                        <td>{{ $product->created_at }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">No products defined.</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $products->links() }}
@endsection
