let express = require('express');
let app = express();
let http = require('http').Server(app);
let redis = require('redis');
let client = redis.createClient("redis://127.0.0.1:6379");
// let clients = redis.createClient("redis://127.0.0.1:6379");

let io = require('socket.io')(http);
app.use('/', express.static('www'));

http.listen(3000, '165.227.53.211', function(){
    console.log('listening on *:3000');
});

client.on('message', function(chan, msg) {
    let data = JSON.parse(msg);
    io.sockets.emit(data.channel, msg);
});

client.subscribe('chat-message');




