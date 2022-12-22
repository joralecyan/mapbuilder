const express = require('express');

const app = express();

const server = require('http').createServer(app);

const io = require('socket.io')(server, {
    cors: { origin: "*"},
    allowEIO3: true
});

io.on('connection', (socket) => {
    console.log('connection');

    socket.on('to_server', (message) => {
        console.log(message);
        socket.broadcast.emit(message.room, message);
    });

    socket.on('disconnect', (socket) => {
        console.log('Disconnect');
    });
});

server.listen(3000, () => {
    console.log('Server is running');
});
