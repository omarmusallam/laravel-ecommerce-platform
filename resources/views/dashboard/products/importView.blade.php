@extends('layouts.dashboard')

@section('title', 'Import Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Import Products</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <h3>An error occurred.</h3>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <x-form.label>Excel File</x-form.label>
            <x-form.input type="file" name="file" />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Import</button>
        </div>
    </form>

@endsection

