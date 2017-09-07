var esubChartManager = {
    buildChart: function (data, element, timeInterval) {
        var chart = bb.generate({
            "data": {
                "x": "x",
                "columns": data,
                type: "spline"
            },
            "transition": {
                "duration": 0
            },
            "axis": {
                "x": {
                    type: "timeseries",
                    "tick": {
                        "fit": false,
                        "format": this.getTimeFormat(timeInterval),
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
            "bindto": element,
        });

        return chart;
    },

    getTimeFormat: function (timeInterval) {
        switch (timeInterval) {
            case 'real-time':
                return "%H:%M:%S";
            case '1m':
                return "%H:%M";
            case '5m':
                return "%H:%M";
            case '60m':
                return "%H:%M";
            case '6h':
                return "%d/%m %H:%M";
            case '24h':
                return "%d/%m/%Y";
        }
    }
};