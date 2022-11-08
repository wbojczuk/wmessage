<div id="mailExpandedWrapper">
    <aside id="mailExpanded">
        <?php
        require_once("./inc/inc_user_data.php");
        $current_requests = get_friend_requests($_SESSION["user"]);
        if(count($current_requests) > 0){
            foreach($current_requests as $request){
                $person_data = get_user($request);
                ?>
                <div class="mail-item">
                Friend Request From <?php echo "{$person_data[1]} {$person_data[2]}." ?>
                <img src="./img/default_pfp.svg" alt="" class="mail-item-icon">
                <a href="index.php?addfriend=<?php echo($request); ?>"><img src="./img/green_checkmark.svg" alt="" class="mail-item-icon-yes"></a>
                <a href="index.php?denyfriend=<?php echo($request); ?>"><img src="./img/red_exit.svg" alt="" class="mail-item-icon-no"></a>
                </div>
                <?php
            }
        }else{
            ?>
                <div class="mail-item">
                NO FRIEND REQUESTS :(
                </div>
            <?php
        }
            
        ?>
        
    </aside>
</div>