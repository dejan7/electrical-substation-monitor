var monitor = new Vue({
    el: '#app',
    data: function() {
        return {
            activeLID: -1, //location ID
            substations: substations, //see MonitorController
            chartsToDraw: eSubCharts,
            socket: null,
            chartsRequestingSocketCon: 0
        }
    },
    methods: {
        changeSubstation: function (lid) {
            this.activeLID = lid;
            this.chartsRequestingSocketCon = 0;

            //notify WS server that we need different Location ID data now
            if (this.socket && this.socket.connected) {
                this.socket.emit('location-id', this.activeLID);
            }
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            // Code that will run only after the
            // entire view has been rendered
            this.activeLID = substations[2].location_id;

            /**
             * setup socket, but don't connect yet
             */
            this.socket = io(SITE_URL + ":3030", {autoConnect: false});
            this.socket.on('connect', function() {
                this.socket.emit('location-id', this.activeLID);
            }.bind(this));

            this.socket.on('new-data', function(data){
                eventBus.$emit('new-data', data);
                //console.log(data);
            });

            /**
             * connect socket only if there's at least one real-time graph
             */
            eventBus.$on("requesting-websocket-connect", function () {
                if (this.chartsRequestingSocketCon === 0)
                    this.socket.open();

                this.chartsRequestingSocketCon++;
            }.bind(this));

            /**
             * close socket connection if there are no active graphs remaining
             */
            eventBus.$on("requesting-websocket-disconnect", function () {
                this.chartsRequestingSocketCon--;

                if (this.chartsRequestingSocketCon === 0)
                    this.socket.close();
            }.bind(this));
        });
    }
});