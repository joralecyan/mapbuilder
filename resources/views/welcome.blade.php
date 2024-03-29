<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat App Socket.io | CodeCheef</title>
</head>
<body>

<div class="container">
    <div class="row chat-row">
        <div class="chat-content">
            <ul></ul>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js" integrity="sha384-LzhRnpGmQP+lOvWruF/lgkcqD+WDVt9fU3H4BWmwP5u5LTmkUGafMcpZKNObVMLU" crossorigin="anonymous"></script>

<script>
    $(function() {
        let ip_address = '{{config('socket.host')}}';
        let socket_port = '{{config('socket.port')}}';
        let socket = io(ip_address + ':' + socket_port);

        socket.on('game_2', (message) => {
            $('.chat-content ul').append(`<li>${message.event}</li>`);
        });
    });
</script>
</body>
</html>
