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
            add_friend($add_user, $_SESSION["user"]);
            
        }
            
            $friends_length = count($friends);
            
            if($friends_length > 0){
                $friends_html = "<div class='fl-wrapper'>";
                for($i = 0; $i < $friends_length; ++$i){
                    $friends_html .= "<div class='fl-person fl-friend' title='{$friends[$i]}'></div>";
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
                $current_user_data = get_user_data();
                $current_users = get_usernames($current_user_data);
                $nonfriends = get_nonfriends($friends ,$current_users);
               
                $nonfriends_length = count($nonfriends);
        
                if($nonfriends_length > 0){
                    $nonfriends_html = "<div class='fl-wrapper'>";
                    for($i = 0; $i < $nonfriends_length; ++$i){
                        $nonfriends_html .= "<div class='fl-person fl-nonfriend' title='{$nonfriends[$i]}'></div>";
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