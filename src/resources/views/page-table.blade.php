@extends('cms::page')

@push('scripts')
    <!--script src="{{ asset('js/v18-sort.js') }}"></script-->
@endpush

@section('bread','')

@section('main')

@include('cms::table')

@endsection
