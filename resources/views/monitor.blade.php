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
    <script src="{{ asset('js/esub-monitor/esub-vars.js') }}"></script>
    <script src="{{ asset('js/esub-monitor/esub-chart.js') }}"></script>
    <script src="{{ asset('js/esub-monitor/monitor.js') }}"></script>
    <script>
        var data = [];

        for (var i=0; i < 10; i++) {
            data.push({x: new Date(points[i].time), y: points[i].mean_IPTA});
        }


        setTimeout(function () {
            return
            chart.flow({
                columns: [
                    ['mAH', '2013-01-11', '2013-01-12', '2013-01-12'],
                    ['Struja (mAh)', 500, 200, 100],
                ],
                duration: 1000,
                done: function () {
                    chart.flow({
                        columns: [
                            ['mAH', '2013-01-13', '2013-01-14', '2013-01-15'],
                            ['Struja (mAh)', 200, 300, 100],
                        ],
                        length: 0,
                        duration: 1000,
                        done: function () {
                            chart.flow({
                                columns: [
                                    ['mAH', '2013-01-16', '2013-01-17', '2013-01-18'],
                                    ['Struja (mAh)', 200, 300, 100],
                                ],
                                length: 0,
                                duration: 1000,
                                done: function () {
                                    chart.flow({
                                        columns: [
                                            ['mAH', '2013-01-19', '2013-01-20', '2013-01-21'],
                                            ['Struja (mAh)', 500, 200, 100],
                                        ],
                                        duration: 1000,
                                    });
                                }
                            });
                        }
                    });
                },
            });
        }, 1000);

    </script>
@endsection