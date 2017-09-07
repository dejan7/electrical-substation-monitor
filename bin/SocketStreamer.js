var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var bodyParser = require('body-parser');

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

io.on('connection', function(client){
    client.on('location-id', function(data){
        client.lid = data;
    });
});


http.listen(3030, function(){
    console.log('listening on *:3030');
});

app.post('/', function (req, res) {
    //console.log(req.body.LOCATION_ID);
    for (let i in io.sockets.connected) {
        let s = io.sockets.connected[i];
        if (req.body.LOCATION_ID == s.lid)
            s.emit("new-data", req.body);
    }
    res.sendStatus(204);
});