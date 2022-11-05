<?php

function send_friend_request($friend, $requester){
    $result = true;
    if(!friend_request_exists($friend, $requester)){
        if(friend_request_exists($requester, $friend)){
            add_friend($requester, $friend);
            add_friend($friend, $requester);

            remove_friend_request($requester, $friend);
            remove_friend_request($friend, $requester);
        }else{
            file_put_contents("./data/requests/$friend.txt", "$requester" . ";", FILE_APPEND);
        }
    }else{
        $result = false;
    }
    return $result;
}

function remove_friend_request($requester, $friend){
    $requests_txt = file_get_contents("./data/requests/$friend.txt");
    echo $requests_txt;
    str_replace("$requester;", "", $requests_txt);
    file_put_contents("./data/requests/$friend.txt", $requests_txt);
}

function friend_request_exists($friend, $requester){
    $retval = false;
    $current_requests = get_friend_requests($friend);
    if(in_array($requester, $current_requests)){
        $retval = true;
    }
    return $retval;
}

function get_friend_requests($friend){
    // Check for friend requests
    $retval = array();
    $requests_txt = file_get_contents("./data/requests/$friend.txt");
    $requests_array = explode(";", $requests_txt);
    if(count($requests_array) > 0){
        array_pop($requests_array);
        $retval = $requests_array;
    }
    return $retval;
}

function get_user_data(){
    $text_data = file_get_contents("./data/users.txt");
    $user_data = explode(";", $text_data);
    $all_user_data = array();
    foreach($user_data as $user){
        $all_user_data[] = explode(":", $user);
        
    }
    if(count($all_user_data) > 0){
        array_pop($all_user_data);
    }
    
    return $all_user_data;
}
function get_user_data_nopass(){
    $text_data = file_get_contents("./data/users.txt");
    $user_data = explode(";", $text_data);
    $all_user_data = array();
    foreach($user_data as $user){
        $temp_array = explode(":", $user);
        array_pop($temp_array);
        $all_user_data[] = $temp_array;
        
    }
    if(count($all_user_data) > 0){
        array_pop($all_user_data);
    }
    
    return $all_user_data;
}
    function get_friends($requested){
        $username = $requested;
        $retval = array();
        $friends_txt = file_get_contents("./data/friends/$username.txt");
        $friends_array = explode(";", $friends_txt);
        if(count($friends_array) > 0){
            array_pop($friends_array);
            $retval = $friends_array;
        }
        return $retval;
    }
    function get_usernames(&$user_data){
        $retval = array();
        $user_length = count($user_data);
        if($user_length > 0){
            for($i = 0; $i < $user_length; ++$i){
                $retval[] = $user_data[$i][0];
            }
        }
        return $retval;
    }
    function get_nonfriends($friends, &$users){
        $friends[] = $_SESSION["user"];
        $retval = array();
        if((count($friends) > 0) && (count($users) > 0)){
            $retval = array_diff($users, $friends);
            $retval = array_values($retval);
        }
        return $retval;
    }

    function user_exists($name, &$user_data){
        $result = false;
        foreach($user_data as $user){
            if(strtolower($user[0]) == strtolower($name)){
                $result = true;
                break;
            }
        }
        return $result;
    }

    function get_user($name, &$user_data){
        $data = array();
        foreach($user_data as $user){
            if(strtolower($user[0]) == strtolower($name)){
                
            $data = $user;
            break;
        }
          
    }
    return $data; 
}
function add_friend($new, $requested){
    $friends = get_friends($requested);
    if(!in_array($new,$friends)){
        file_put_contents("./data/friends/$requested.txt", $new . ";", FILE_APPEND);
    }
}
?>