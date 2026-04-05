@extends('layouts.dashboard')

@section('title', 'Users')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Users</li>
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
            .admin-filter-form { display: grid; grid-template-columns: 1fr 1fr auto; gap: .75rem; }
            .admin-filter-form .form-control { border-radius: 14px; height: 46px; border-color: #d6e3f2; }
            .admin-table-card { overflow: hidden; }
            .admin-table-card .table { margin: 0; }
            .admin-table-card thead th { border: 0; background: #f8fbff; color: #667085; font-size: .78rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
            .admin-table-card td { vertical-align: middle; border-color: #edf2f7; }
            .admin-user-name { font-weight: 700; color: #142033; }
            .admin-row-actions { display: flex; gap: .45rem; justify-content: flex-end; }
            .admin-row-actions .btn { border-radius: 12px; }
            .admin-table-footer { padding: 1rem 1.25rem; border-top: 1px solid #edf2f7; background: #fff; }
            @media (max-width: 991.98px) { .admin-filter-form { grid-template-columns: 1fr; } }
        </style>
    @endpush

    <div class="admin-page-header">
        <h2 class="h4 mb-0">Users</h2>
        <p>Manage customer accounts, review registrations, and move quickly between editing and account maintenance.</p>
    </div>

    <div class="admin-toolbar">
        <div class="admin-actions">
        @can('users.create')
            <a title="Create user" href="{{ route('dashboard.users.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> New User</a>
        @endcan
        </div>

    <x-alert type="success" />
    <x-alert type="info" />

        <form action="{{ URL::current() }}" method="get" class="admin-filter-form">
            <x-form.input name="name" placeholder="Search by name" :value="request('name')" />
            <x-form.input name="email" placeholder="Search by email" :value="request('email')" />
            <button class="btn btn-primary"><i class="fas fa-search mr-1"></i> Filter</button>
        </form>
    </div>

    <div class="admin-table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td><a href="{{ route('dashboard.users.edit', $user->id) }}" class="admin-user-name">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="admin-row-actions">
                                @can('users.update')
                                    <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('users.delete')
                                    <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No users defined.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="admin-table-footer">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>

@endsection
