<?php
require_once("./inc/inc_user_data.php");
?>

<aside id="friendsListWrapper">
    <div id="friendsList">

        <div class="friends">
        <div class="title">Friends</div>

        <?php
        $friends = get_friends($_SESSION["user"]);
        // ADD NEW FRIENDS
        if(isset($_GET['addfriend'])){
            $add_user = $_GET['addfriend'];
            send_friend_request($add_user, $_SESSION["user"]);
            header("Location:index.php");
        }
        if(isset($_GET['denyfriend'])){
            $remove_user = $_GET['denyfriend'];
            remove_friend_request($remove_user, $_SESSION["user"]);
            header("Location:index.php");
        }
        if(isset($_GET['removefriend'])){
            $remove_user = $_GET['removefriend'];
            remove_friends($remove_user, $_SESSION["user"]);
            header("Location:index.php");
        }
            
            $friends_length = count($friends);
            
            if($friends_length > 0){
                $friends_html = "<div class='fl-wrapper'>";
                for($i = 0; $i < $friends_length; ++$i){
                    $current_user = get_user($friends[$i]);
                    $friends_html .= "<div class='fl-person fl-friend' title='{$current_user[1]} {$current_user[2]}' data-title='{$current_user[0]}''></div>";
                    if($i == ($friends_length - 1)){
                        $friends_html .= "</div>";
                    }else if(($i != 0) && (($i % 2) == 0)){
                        $friends_html .= "</div><div class='fl-wrapper'>";
                    }
                
                }
                echo($friends_html);
            }
        ?>
        </div>

        <div class="notfriends">
            <div class="title">People</div>

            <?php
                
                $current_users = get_usernames();
                $nonfriends = get_nonfriends($friends ,$current_users);
                
               
                $nonfriends_length = count($nonfriends);
        
                if($nonfriends_length > 0){
                    $nonfriends_html = "<div class='fl-wrapper'>";
                    for($i = 0; $i < $nonfriends_length; ++$i){
                        $current_user = get_user($nonfriends[$i]);
                        $nonfriends_html .= "<div class='fl-person fl-nonfriend' title='{$current_user[1]} {$current_user[2]}' data-title='{$current_user[0]}'></div>";
                        if($i == ($nonfriends_length - 1)){
                            $nonfriends_html .= "</div>";
                        }else if(($i != 0) && ((($i + 1) % 2) == 0)){
                            $nonfriends_html .= "</div><div class='fl-wrapper'>";
                        }
                    
                    }
                    echo($nonfriends_html);
                }
            ?>
        </div>

        <div class="fl-user">
        <?php echo("Logged in as " . $_SESSION['user'] . "."); ?>
        </div>
        <a href="./index.php?action=logout" class="fl-logout">LOGOUT</a>
    </div>
</aside>