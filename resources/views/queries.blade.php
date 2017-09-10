@extends('layouts.dashboard')

@section('pageName', "Upiti")


@section('page')
    <div id="queryContent"><!--see esub-query.js--></div>



@endsection

@section('scripts')
    <script src="{{ asset('js/esub-monitor/esub-query.js') }}"></script>
    <script>

    </script>
@endsection