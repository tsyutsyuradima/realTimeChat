<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Chat';
?>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="/web/js/js/server/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js"></script>
<script src="/web/js/js/client/client.js"></script>
<script>
    var socket = new YiiNodeSocket();
    socket.debug(true);
    var testRoom;

    socket.on('room_leave', function(){
        alert('ss');
    });

    socket.onConnect(function () {

        console.log(socket.roomClients);

        var room = socket.room('chatRoom').join(function (success, numberOfRoomSubscribers) {
            if (success && numberOfRoomSubscribers <= 2) {
                if (numberOfRoomSubscribers == 1) {
                    $('#wait').css({ 'display': "block" });
                }
                else {
                    $('#chat').css({ 'display': "block" });
                    this.emit('toJoin' , {
                        message : {
                            id : <?=Yii::$app->getUser()->identity->id?>,
                            username : '<?=Yii::$app->getUser()->identity->username?>'
                        }
                    });
                }
            } else {
                $('#excessive').css({ 'display': "block" });
            }
        });

        room.on('sendMessage', function (data) {
            if (data.message.msg === '') return false;
            var who = '';
            if (data.message.id == <?=Yii::$app->getUser()->identity->id?>) {
                who = 'me';
            } else {
                who = 'you';
            }
            $('.chatList').append('<li class="' + who + '"><span class="name">' + data.message.username + '</span><span class="msg">' + data.message.msg + '</span></li>');
        });

        room.on('sendSystemMessage', function (data) {
            $('.chatList').append('<li class="system">' + data.message.username + ' ' + data.message.msg + '</li>');
        });

        room.on('toJoin', function (data) {
            if (data.message.id == <?=Yii::$app->getUser()->identity->id?>) {
                $('.chatList').append('<li class="system">You have successfully joined!</li>');
            }
            else
            {
                $('#wait').css({ 'display': "none" });
                $('#chat').css({ 'display': "block" });
                $('.chatList').append('<li class="system">' + data.message.username + ' have successfully joined!</li>');
            }
        });

        room.on('toLeave', function (data) {
            console.log(data.countClients);
            if (data.countClients == 2) {
                $('#wait').css({ 'display': "block" });
                $('#chat').css({ 'display': "none" });
                $('.chatList').html('');
            }
        });

        $("#send").on("click", function () {
            var msg = $("#message textarea");
            room.emit('sendMessage' , {
                message : {
                    id : <?=Yii::$app->getUser()->identity->id?>,
                    username : '<?=Yii::$app->getUser()->identity->username?>',
                    msg : msg.val()
                }
            });
            msg.val('').focus();
            $('.chatList').animate({ scrollTop: $(".chatList")[0].scrollHeight }, 100);

        });

        $('#message textarea').keypress(function(e){
            if(e.which == 13) {
                e.preventDefault();
                $("#send").trigger('click');
            }

        });
    });
</script>
<div id="excessive" style="display: none;">
    <h3>Oops, you can not join this chat!</h3>
    <h4>There are already two people in it</h4>
</div>
<div id="wait" style="display: none;">
    <h3>There are no other people in this chat!</h3>
    <h4>Wait...</h4>
</div>
<div id="chat" style="display: none;">
    <ul class="chatList"></ul>
    <div id="message">
        <textarea></textarea>
        <button id="send">Send</button>
    </div>
</div>

