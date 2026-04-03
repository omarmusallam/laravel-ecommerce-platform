@extends('layouts.dashboard')
@section('title', 'Settings')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Settings</li>
@endsection
@section('content')
    <x-alert type="success" />
    <x-alert type="info" />

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Website settings</h4>
                </div>
                <div class="card-body">
                    @if (!isset($settings))
                        @can('settings.create')
                            <a href="{{ route('dashboard.setting.create') }}"
                                class="btn btn-sm btn-outline-primary mr-2">Create</a>
                        @endcan
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>Name</th>
                                        <th>Currency</th>
                                        <th>WhatsApp</th>
                                        <th>Mail</th>
                                        <th>Tax number</th>
                                        <th>Site Logo</th>
                                        <th>Outro logo</th>
                                        <th>tab logo</th>
                                        <th>QR Code</th>
                                        <th>Invoice Stamp</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $settings->name }}</td>
                                        <td>{{ $settings->currency }}</td>
                                        <td>{{ $settings->phone }}</td>
                                        <td>{{ $settings->email }}</td>
                                        <td>{{ $settings->tax_number }}</td>
                                        <td><img src="{{ $settings->website_logo_url }}" width="150px"
                                                alt="" style="max-height: 50px;"></td>
                                        <td><img src="{{ $settings->epilogue_logo_url }}" width="150px"
                                                alt="" style="max-height: 50px;"></td>
                                        <td><img src="{{ $settings->tab_logo_url }}" width="150px"
                                                alt="" style="max-height: 50px;"></td>
                                        <td><img src="{{ $settings->qr_code_url }}" alt=""
                                                style="max-height: 50px;"></td>
                                        <td><img src="{{ $settings->invoice_stamp_url }}" alt=""
                                                style="max-height: 50px;"></td>
                                        @can('settings.update')
                                            <td>
                                                <a href="{{ route('dashboard.setting.edit', $settings->id) }}"
                                                    class="btn btn-sm btn-outline-primary">Edit</a>
                                            </td>
                                        @endcan
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
