Vue.component('esub-chart', {
    // declare the props
    props: ['locationId', 'chartType'],
    data: function () {
        return {
            intervals: eSubIntervals,
            activeInterval: '1m',
            updating: false
        }
    },
    watch: {
        locationId: function (val, oldval) {
            this.updateGraph();
            console.log(this.chartType);
        },
        activeInterval: function (val, oldVal) {
            this.updateGraph();
        }
    },
    methods: {
        updateGraph: function () {
            this.updating = true;
            this.$http.get(SITE_URL + '/api/measurement/'+this.activeInterval+'/'+this.locationId+'/' + this.chartType.value).then(function (res) {
                //console.log(res.body);
                var fields = res.body;
                var columns = [];
                var i = 0;
                for (var line in fields) {
                    if (fields.hasOwnProperty(line)) {
                        if (columns.length == 0) {
                            fields[line].x.unshift("x");
                            columns.push(fields[line].x);
                        }
                        fields[line].y.unshift(this.chartType.labels[i]);
                        columns.push(fields[line].y)
                        i++;
                    }
                }
                var chart = bb.generate({
                    "data": {
                        "x": "x",
                        "columns": columns
                    },
                    "axis": {
                        "x": {
                            "type": "timeseries",
                            "tick": {
                                "format": "%H:%M"
                            }
                        }
                    },
                    "color": {
                        "pattern": [
                            "#7AC29A",
                            "#00bbff",
                            "#EB5E28",
                        ]
                    },
                    point: {
                        r: 5,
                    },
                    "bindto": this.$refs.chartDiv,

                });

                this.updating = false;
            }, function (err) {
                console.log(err);
                this.updating = false;
            });
        }
    },
    created: function () {
        console.log();
    },
    template: `
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="title">{{chartType.name}}</h4>
                            <p class="category">Interval: {{intervals[activeInterval]}}</p>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-inline text-right-lg text-right-md">
                                <label v-show="!updating"><i class="fa fa-refresh"></i> Automatsko osvežavanje za: <strong>00:54</strong></label>
                                <label v-show="updating"><strong><i class="fa fa-refresh fa-spin"></i> Učitavam</strong></label>
                                <label><i class="fa fa-clock-o"></i>Izaberi interval: </label>
                                <select v-model="activeInterval" class="form-control border-input">
                                    <option v-for="(val, key) in intervals" :value="key">{{val}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="content">
                    <div class="esubChart" ref="chartDiv"></div>
                </div>
            </div>
        </div>
    </div>
    `

});