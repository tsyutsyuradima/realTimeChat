<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Chat';
?>

<script src="/js/js/server/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js"></script>
<script src="/js/js/client/client.js"></script>
<script>
    var socket = new YiiNodeSocket();
    socket.debug(true);

    socket.onConnect(function () {
        alert('onConnect');
    });

    socket.onDisconnect(function () {
        alert('onDisconnect');
    });

    socket.onConnecting(function () {
        console.log('onConnecting');

    });

    socket.onReconnect(function () {
        alert('onReconnect');
    });


    socket.emit('global.event', {
        message : {
            id : 12,
            title : 'This is a test message'
        }
    });

    socket.on('global.event', function (data) {
       alert(data.message.title); // you will see in console `This is a test message`
    });
</script>

