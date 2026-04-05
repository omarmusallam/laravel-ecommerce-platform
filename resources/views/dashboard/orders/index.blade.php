@extends('layouts.dashboard')
@section('title', 'Orders')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Orders</li>
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
            .admin-filter-form { display: grid; grid-template-columns: 1fr auto; gap: .75rem; }
            .admin-filter-form .form-control { border-radius: 14px; height: 46px; border-color: #d6e3f2; }
            .admin-filter-form .btn { border-radius: 999px; }
            .admin-table-card { overflow: hidden; }
            .admin-table-card .table { margin: 0; }
            .admin-table-card thead th {
                border: 0; background: #f8fbff; color: #667085; font-size: .78rem; font-weight: 700;
                letter-spacing: .04em; text-transform: uppercase; white-space: nowrap;
            }
            .admin-table-card td { vertical-align: middle; border-color: #edf2f7; }
            .admin-status-pill, .admin-payment-pill {
                display: inline-flex; align-items: center; padding: .35rem .7rem; border-radius: 999px;
                font-size: .75rem; font-weight: 700; text-transform: capitalize;
            }
            .admin-status-pill { background: #eef6ff; color: #1f7aff; }
            .admin-payment-pill { background: #f3fbf7; color: #16794f; }
            .admin-row-actions { display: flex; gap: .45rem; justify-content: center; }
            .admin-row-actions .btn { border-radius: 12px; }
            .admin-table-footer { padding: 1rem 1.25rem; border-top: 1px solid #edf2f7; background: #fff; }
            @media (max-width: 991.98px) { .admin-filter-form { grid-template-columns: 1fr; } }
        </style>
    @endpush

    <x-alert type="success" />
    <x-alert type="info" />

    <div class="admin-page-header">
        <h2 class="h4 mb-0">Orders</h2>
        <p>Review recent orders, payment status, and processing actions from one clearer operational table.</p>
    </div>

    <div class="admin-toolbar">
        <form action="{{ URL::current() }}" method="get" class="admin-filter-form">
            <x-form.input name="name" placeholder="Search by order number" :value="request('name')" />
            <button class="btn btn-primary"><i class="fas fa-search mr-1"></i> Filter</button>
        </form>
    </div>

    <div class="admin-table-card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Number</th>
                    <th>Store</th>
                    <th>User</th>
                    <th>Payment</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($orders->count())
                    @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td><a href="{{ route('dashboard.orders.show', $order->id) }}" class="font-weight-bold text-dark">{{ $order->number }}</a></td>
                            <td>{{ $order->store->name }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->payment->method }}</td>
                            <td>{{ $order->payment->amount }}</td>
                            <td><span class="admin-payment-pill">{{ $order->payment->status }}</span></td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="admin-row-actions">
                                    <a title="Print pdf" href="{{ route('dashboard.orders.print', $order->id) }}" class="btn btn-sm btn-outline-info" target="_blank"><i class="fas fa-print"></i></a>
                                    @can('orders.show')
                                        <a title="Show order" href="{{ route('dashboard.orders.show', $order->id) }}" class="btn btn-sm btn-outline-success"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('orders.delete')
                                        <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button title="Delete order" type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9" class="text-center py-4">No orders defined.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="admin-table-footer">
            {{ $orders->withQueryString()->appends(['search' => 1])->links() }}
        </div>
    </div>
@endsection
