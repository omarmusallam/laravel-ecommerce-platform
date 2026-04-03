@extends('layouts.dashboard')
@section('title', 'Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')
    <div class="mb-5">
        @if (Auth::user()->can('categories.create'))
            <a title="Create category" href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary mr-2"><i
                    class="fas fa-plus"></i></a>
            <a title="Recycle bin" href="{{ route('dashboard.categories.trash') }}" class="btn btn-sm btn-outline-dark"><i
                    class="fas fa-trash-alt"></i></a>
        @endif
    </div>

    <x-alert type="success" />
    <x-alert type="info" />

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
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
                <th>Parent</th>
                <th>Products #</th>
                <th>Status</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @if ($categories->count())
                @foreach ($categories as $category)
                    <tr>
                        <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50px"></td>
                        <td>{{ $category->id }}</td>
                        <td><a href="{{ route('dashboard.categories.show', $category->id) }}">{{ $category->name }}</a></td>
                        <td>{{ $category->parent->name }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>{{ $category->status }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            @can('categories.update')
                                <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                    class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                            @endcan
                        </td>
                        <td>
                            @can('categories.delete')
                                <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST">
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
                    <td colspan="9">No categories defined.</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $categories->withQueryString()->appends(['search' => 1])->links() }}
@endsection