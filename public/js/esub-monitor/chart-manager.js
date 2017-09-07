var esubChartManager = {
    buildChart: function (data, element, timeInterval, chartType) {
        var graphs = [];
        var types = chartType.value.split(",");
        var colors = types.length == 3 ? chartColors.short : chartColors.long;
        for (var i = 0; i<types.length;i++) {
            graphs.push({
                "id": types[i],
                /*"balloon":{
                    "drop":true,
                    "adjustBorderColor":false,
                    "color":"#ffffff"
                },*/
                "bullet": "round",
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "bulletSize": 5,
                "hideBulletsCount": 50,
                "type": "smoothedLine",
                "lineThickness": 2,
                "lineColor": colors[i] ? colors[i] : "#fff",
                "title": chartType.labels[i],
                "useLineColorForBulletBorder": true,
                "valueField": timeInterval === 'real-time' ? types[i] : "mean_" + types[i],
                "balloonText": "<span style='font-size:18px;'>"+chartType.labels[i]+": [[value]] "+chartType.unit+"</span>",
                "connect": false
            });
        };

        var chart = AmCharts.makeChart(element, {
            "type": "serial",
            "theme": "light",
            "marginRight": 40,
            "marginLeft": 40,
            "autoMarginOffset": 20,
            "mouseWheelZoomEnabled":false,
            "valueAxes": [{
                "id": "v1",
                "axisAlpha": 0,
                "position": "left",
                "ignoreAxisWidth":true
            }],
            /*"balloon": {
                "borderThickness": 1,
                "shadowAlpha": 0
            },*/
            "legend": {
                "useGraphSettings": true
            },
            "graphs": graphs,
            "chartCursor": {
                "pan": true,
                "valueLineEnabled": true,
                "valueLineBalloonEnabled": true,
                "cursorAlpha":1,
                "cursorColor":"#258cbb",
                "limitToGraph":"g1",
                "valueLineAlpha":0.2,
                "valueZoomable":true
            },
            "categoryField": "time",
            "categoryAxis": {
                "parseDates": false,
                categoryFunction: function (data) {
                    var Date = moment(data);
                    return Date.format(esubChartManager.getTimeFormat(timeInterval));
                },
                "dashLength": 1,
                "minorGridEnabled": true
            },
            "export": {
                "enabled": false
            },
            "dataProvider": data
        });


        return chart;
    },

    getTimeFormat: function (timeInterval) {
        switch (timeInterval) {
            case 'real-time':
                return "HH:mm:ss";
            case '1m':
                return "HH:mm";
            case '5m':
                return "HH:mm";
            case '60m':
                return "HH:mm";
            case '6h':
                return "DD/MM HH:mm";
            case '24h':
                return "DD/MM/YYYY";
        }
    }
};