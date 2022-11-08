<?php

    $current_requests = get_friend_requests($_SESSION["user"]);
    $mail_classes = "mail-icon";
    if(count($current_requests) > 0){
        $mail_classes .= " mail-icon-hasmail";
    }
?>

<div id="mailIcon" class="<?php echo($mail_classes); ?>">

</div>