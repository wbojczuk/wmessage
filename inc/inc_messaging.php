<div class="main-chat-wrapper">
    <div class="wrapper-chats"></div>
    <form id="chatForm" action="index.php" method="POST" style="border:none;width:0px;height:0px;">
        <textarea name="chatInput" id="chatInput" class="chat-input"></textarea>
        <button class="chat-send-button" id="chatSendButton">Send</button>
    </form>
</div>
<?php
require_once("./inc/inc_message_funcs.php");
    if(isset($_POST["chatInput"])){
        if(!empty($_POST["chatInput"])){
            if(!in_array($_GET['chatid'], get_message_ids($_GET['openchat']))){
                send_message($_GET["openchat"], $_POST["chatInput"], $_GET['chatid']);
            }
            
        }
    }
?>