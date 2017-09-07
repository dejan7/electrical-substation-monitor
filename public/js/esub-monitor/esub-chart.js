var eventBus = new Vue();

Vue.component('esub-chart', {
    // declare the props
    props: ['locationId', 'chartType'],
    data: function () {
        return {
            intervals: eSubIntervals,
            activeInterval: '1m',
            updating: false,
            timerInstance: null,
            timeUntilRefresh: 0, //seconds
            chart: null,
            realTimeChartData: []
        }
    },
    watch: {
        locationId: function (val, oldval) {
            this.updateGraph();
        },
        activeInterval: function (val, oldVal) {
            if (oldVal === 'real-time')
                eventBus.$emit('requesting-websocket-disconnect');
            this.updateGraph();
        }
    },
    methods: {
        updateGraph: function () {
            if (this.activeInterval === 'real-time') {
                this.startSocketConnection();
                this.drawRealTimeChart();
            } else {
                this.sendAPIrequest();
            }
        },
        sendAPIrequest: function () {
            this.updating = true;
            this.$http.get(SITE_URL + '/api/measurement/'+this.activeInterval+'/'+this.locationId+'/' + this.chartType.value).then(function (res) {
                for (var i = 0; i< res.body.length; i++) {
                    if (res.body[i][0] === "x")
                        continue;
                    res.body[i][0] = this.chartType.labels[i-1];
                }

                this.chart = esubChartManager.buildChart(res.body, this.$refs.chartDiv, this.activeInterval);

                //this.startTimer();
                this.updating = false;

            }, function (err) {
                console.log(err);
                this.updating = false;
            });
        },
        startSocketConnection: function () {
            eventBus.$emit('requesting-websocket-connect');
        },
        drawRealTimeChart: function () {
            this.realTimeChartData = [];
            this.realTimeChartData.push(['x']);
            for (let i = 0; i< this.chartType.labels.length; i++) {
                this.realTimeChartData.push([this.chartType.labels[i]]);
                for (let j=0;j <30;j++) {

                }
            }


            this.chart = esubChartManager.buildChart([], this.$refs.chartDiv, this.activeInterval);
        },
        updateRealTimeChart: function (data) {
            if (this.activeInterval != 'real-time')
                return;
            //console.log(data);
            let values = this.chartType.value.split(",");
            for (let i = 0; i<= this.chartType.labels.length; i++) {
                if (i==0)
                    this.realTimeChartData[i].push(data.READ_TIME);
                else
                    this.realTimeChartData[i].push(data[values[i-1]]);
            }
            if (this.realTimeChartData[0].length > 30) {
                for (var k in this.realTimeChartData) {
                    if (this.realTimeChartData.hasOwnProperty(k)) {
                        this.realTimeChartData[k].splice(1,1);
                    }
                }
            }
            this.chart.load({
                columns: this.realTimeChartData,
                //duration: 1000
            });

        },
        startTimer: function () {
            this.stopTimer();
            if (this.activeInterval !== '1m')
                return;

            this.timeUntilRefresh = 60;

            this.timerInstance = setInterval(function () {
                this.timeUntilRefresh--;
                if (this.timeUntilRefresh === 0) {
                    this.updateGraph();
                    this.stopTimer();
                }
            }.bind(this), 1000);
        },
        stopTimer: function () {
            clearInterval(this.timerInstance);
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            eventBus.$on('new-data', function (data) {
                this.updateRealTimeChart(data);
            }.bind(this))
        });
    },
    template: `
    <div class="row">
        <div class="col-md-12">
            <div class="card" :class="{'realTimeChart' : activeInterval == 'real-time'}">
                <div class="header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="title">{{chartType.unitMeasure}}</h4>
                            <p class="category">Interval: <span class="liveTick"></span> {{intervals[activeInterval]}}</p>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-inline text-right-lg text-right-md">
                                <label v-show="!updating && activeInterval == '1m'"><i class="fa fa-refresh"></i> Automatsko osvežavanje za: <strong>00:{{timeUntilRefresh < 10 ? "0" + timeUntilRefresh : timeUntilRefresh}}</strong></label>
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