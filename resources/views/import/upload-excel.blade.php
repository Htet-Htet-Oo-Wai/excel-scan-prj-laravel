@extends('app')

@section('css')
<style>
    .card-outer {
        min-height: 100vh;
    }
</style>
@endsection

@section('content')

<div class="align-items-center d-flex justify-content-center card-outer bg-info">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Please upload excel file.</h5>
            <form action="{{ route('import.import-excel') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }} <a href="{{ route('import.report-excel') }}"> Go to Detail Report</a>
                </div>
                @endif
                <div class="mb-3">
                    <label for="excel_input" class="form-label">Excel File</label>
                    <input type="file" class="form-control" name="file" id="excel_input">
                </div>
                <input type="submit" value="submit" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

@endsection