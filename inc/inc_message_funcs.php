<?php


    function send_message($user, $message, $id){
        $clean_chat = str_replace("~","-", $message);
        $clean_chat = str_replace("`","'", $clean_chat);
        $clean_chat = htmlentities($clean_chat);
        $clean_chat = nl2br($clean_chat);
        $sorted_users = [$user, $_SESSION['user']];
        sort($sorted_users);
            file_put_contents("./data/messages/{$sorted_users[0]}_{$sorted_users[1]}.txt", $_SESSION['user'] . "~" . $clean_chat . "~$id" . "`", FILE_APPEND);
    }
    function get_message_ids($user){
        $retval = array();
        $message_txt = "";
        $sorted_users = [$user, $_SESSION['user']];
        sort($sorted_users);
        $message_txt = file_get_contents("./data/messages/{$sorted_users[0]}_{$sorted_users[1]}.txt");
        $msg_array = explode("`", $message_txt);
        array_pop($msg_array);
        foreach($msg_array as $msg){
            $cur_msg = explode("~", $msg);
            $retval[] = $cur_msg[2];
        }
        return $retval;
    }


?>