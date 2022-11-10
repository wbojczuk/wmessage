<?php


    function send_message($user, $message, $id){
        $clean_chat = str_replace("~","-", $message);
        $clean_chat = str_replace("`","'", $clean_chat);
        $clean_chat = htmlentities($clean_chat);
        $clean_chat = nl2br($clean_chat);
        if(file_exists("./data/messages/{$user}_{$_SESSION['user']}.txt")){
            file_put_contents("./data/messages/{$user}_{$_SESSION['user']}.txt", $_SESSION['user'] . "~" . $clean_chat . "~$id" . "`", FILE_APPEND);
        }else{
            file_put_contents("./data/messages/{$_SESSION['user']}_{$user}.txt", $_SESSION['user'] . "~" . $clean_chat . "~$id" . "`", FILE_APPEND);
        }
    }
    function get_message_ids($user){
        $retval = array();
        $message_txt = "";
        if(file_exists("./data/messages/{$user}_{$_SESSION['user']}.txt")){
            $message_txt = file_get_contents("./data/messages/{$user}_{$_SESSION['user']}.txt");
        }else{
            $message_txt = file_get_contents("./data/messages/{$_SESSION['user']}_{$user}.txt");
        }
        $msg_array = explode("`", $message_txt);
        array_pop($msg_array);
        foreach($msg_array as $msg){
            $cur_msg = explode("~", $msg);
            $retval[] = $cur_msg[2];
        }
        return $retval;
    }


?>