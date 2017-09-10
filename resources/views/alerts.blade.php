@extends('layouts.dashboard')

@section('pageName', "Korisnici")


@section('headerNavigation')

@endsection

@section('page')
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h1>Upozorenja i obaveštenja</h1>
                </div>
                <div class="content">
                    <form method="POST" action="{{url('/alerts')}}">
                        {!! csrf_field() !!}
                        <div id="esubalerts">

                        </div>
                        <br><br><button class="btn btn-primary btn-lg btn-fill" type="submit">Zapamti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
         var alerts = new Vue({
             el: '#esubalerts',
             data: function () {
                return {
                    dataKeyValues: eSubKeyValues,
                    rows: alerts
                }
             },
             methods: {
                 addRow : function () {
                     this.rows.push({column: "IPTL", comparison: "gt", value: 5, interval: "1m"});
                 },
                 removeRow: function (i) {
                     this.rows.splice(i, i);
                 },
             },
             template: `
             <div>
                <div v-show="rows.length == 0">
                    <h3>Trenutno nemate nijedno podešeno upozorenje.</h3>
                    <button class="btn btn-primary" @click="addRow()" type="button">Dodaj Upozorenje</button>
                </div>
                <div v-for="(row, i) in rows">
                Ukoliko
                <select class="form-control inlinecontrol border-input" v-model="row.column" name="column[]">
                    <option v-for="(value, key) in dataKeyValues" :value="key">@{{value}}</option>
                </select>
                Bude
                <select class="form-control inlinecontrol border-input" v-model="row.comparison" name="comparison[]">
                    <option value="gt">Veće</option>
                    <option value="lt">Manje</option>
                </select>
                od
                <input class="form-control inlinecontrol border-input" placeholder="Vrednost" value="5" v-model="row.value" name="value[]">
                u periodu od
                <select class="form-control inlinecontrol border-input" v-model="row.interval" name="interval[]">
                    <option value="1m">1 minut</option>
                    <option value="5m">5 minuta</option>
                    <option value="60m">60 minuta</option>
                    <option value="6h">6 sati</option>
                    <option value="24h">24 časova</option>
                </select>
                pošalji mi mail.
                <button v-show="i == (rows.length-1)" class="btn btn-success btn-fill" @click="addRow()" type="button">+</button>
                <button class="btn btn-danger btn-fill" @click="removeRow(i)" type="button">-</button>
                <hr>
                </div>
             </div>
             `
         });

    </script>
@endsection