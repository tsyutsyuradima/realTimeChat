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
    var testRoom;

    socket.onConnect(function () {
        var room = socket.room('chatRoom').join(function (success, numberOfRoomSubscribers) {
            if (success && numberOfRoomSubscribers <= 2) {
                alert(numberOfRoomSubscribers + ' clients in room: ');
                // do something

                // bind events
                this.on('join', function (newMembersCount) {
                    alert(numberOfRoomSubscribers + ' clients in joinjoinjoinjoin: ');
                });

                this.on('data', function (data) {
                    alert(numberOfRoomSubscribers + ' clients in datadatadatadata: ');
                });

                this.on('test', function (data) {
                    alert(numberOfRoomSubscribers + ' clients in TEST TEST: ');
                });

            } else {
                // numberOfRoomSubscribers - error message
                alert(numberOfRoomSubscribers);
            }
        });

        $("#send").on("click", function () {
            room.emit('test' , {
                message : {
                    id : 12,
                    title : 'This is a test message'
                }
            });
        });

    });
</script>

<i id="send">SEND MESSSAGE</i>

