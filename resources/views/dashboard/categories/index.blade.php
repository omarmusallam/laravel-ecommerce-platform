@extends('layouts.dashboard')
@section('title', 'Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection
@section('content')
    @push('styles')
        <style>
            .admin-page-header { margin-bottom: 1.25rem; }
            .admin-page-header p { color: #667085; margin: 0.35rem 0 0; }
            .admin-toolbar, .admin-table-card { background: #fff; border: 1px solid #e6edf7; border-radius: 20px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06); }
            .admin-toolbar { padding: 1rem; margin-bottom: 1rem; }
            .admin-actions { display: flex; flex-wrap: wrap; gap: .75rem; margin-bottom: 1rem; }
            .admin-actions .btn, .admin-filter-form .btn { border-radius: 999px; }
            .admin-filter-form { display: grid; grid-template-columns: 1.2fr 1fr auto; gap: .75rem; }
            .admin-filter-form .form-control { border-radius: 14px; height: 46px; border-color: #d6e3f2; }
            .admin-table-card { overflow: hidden; }
            .admin-table-card .table { margin: 0; }
            .admin-table-card thead th { border: 0; background: #f8fbff; color: #667085; font-size: .78rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
            .admin-table-card td { vertical-align: middle; border-color: #edf2f7; }
            .admin-thumb { width: 56px; height: 56px; border-radius: 14px; object-fit: cover; background: #f8fbff; border: 1px solid #e6edf7; padding: 4px; }
            .admin-status-pill { display: inline-flex; align-items: center; padding: .35rem .7rem; border-radius: 999px; font-size: .75rem; font-weight: 700; text-transform: capitalize; background: #eef6ff; color: #1f7aff; }
            .admin-row-actions { display: flex; gap: .45rem; justify-content: flex-end; }
            .admin-row-actions .btn { border-radius: 12px; }
            .admin-table-footer { padding: 1rem 1.25rem; border-top: 1px solid #edf2f7; background: #fff; }
            @media (max-width: 991.98px) { .admin-filter-form { grid-template-columns: 1fr; } }
        </style>
    @endpush

    <div class="admin-page-header">
        <h2 class="h4 mb-0">Categories</h2>
        <p>Organize catalog structure, monitor product counts, and maintain category status from one clean view.</p>
    </div>

    <div class="admin-toolbar">
        <div class="admin-actions">
            @if (Auth::user()->can('categories.create'))
                <a title="Create category" href="{{ route('dashboard.categories.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> New Category</a>
                <a title="Recycle bin" href="{{ route('dashboard.categories.trash') }}" class="btn btn-outline-dark"><i class="fas fa-trash-alt mr-1"></i> Recycle Bin</a>
            @endif
        </div>

    <x-alert type="success" />
    <x-alert type="info" />

        <form action="{{ URL::current() }}" method="get" class="admin-filter-form">
            <x-form.input name="name" placeholder="Search by category name" :value="request('name')" />
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                <option value="active" @selected(request('status') == 'active')>Active</option>
                <option value="archived" @selected(request('status') == 'archived')>Archived</option>
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
                    <th>Parent</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($categories->count())
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="admin-thumb">
                                @else
                                    <div class="admin-thumb d-flex align-items-center justify-content-center text-muted"><i class="fas fa-layer-group"></i></div>
                                @endif
                            </td>
                            <td>#{{ $category->id }}</td>
                            <td><a href="{{ route('dashboard.categories.show', $category->id) }}" class="font-weight-bold text-dark">{{ $category->name }}</a></td>
                            <td>{{ $category->parent->name }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td><span class="admin-status-pill">{{ $category->status }}</span></td>
                            <td>{{ $category->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="admin-row-actions">
                                    @can('categories.update')
                                        <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('categories.delete')
                                        <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST">
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
                        <td colspan="8" class="text-center py-4">No categories defined.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="admin-table-footer">
            {{ $categories->withQueryString()->appends(['search' => 1])->links() }}
        </div>
    </div>
@endsection
