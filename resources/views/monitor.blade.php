@extends('layouts.dashboard')

@section('pageName', "Monitor")

@section('headerNavigation')
    <ul class="nav navbar-nav">
        <li><a href="#">Trafo stanice:</a></li>
        <li v-for="s in substations">
            <button class="btn btn-primary"
                    @click="changeSubstation(s.location_id)"  :class="{'btn-fill': activeLID == s.location_id}">
                @{{s.name}} (ID: @{{s.location_id}})
            </button>
        </li>
    </ul>
@endsection

@section('page')
    <div v-for="(chart, i) in chartsToDraw"><esub-chart :location-id="activeLID" :chart-type="chart"></esub-chart></div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
    <script src="{{ asset('js/esub-monitor/esub-vars.js') }}"></script>
    <script src="{{ asset('js/esub-monitor/esub-chart.js') }}"></script>
    <script src="{{ asset('js/esub-monitor/chart-manager.js') }}"></script>
    <script src="{{ asset('js/esub-monitor/monitor.js') }}"></script>
@endsection