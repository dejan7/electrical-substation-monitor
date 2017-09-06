var monitor = new Vue({
    el: '#app',
    data: function() {
        return {
            activeLID: -1, //location ID
            substations: substations, //see MonitorController
            chartsToDraw: eSubCharts
        }
    },
    methods: {
        changeSubstation: function (lid) {
            this.activeLID = lid;
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            // Code that will run only after the
            // entire view has been rendered
            this.activeLID = substations[0].location_id;
        })
    }
});