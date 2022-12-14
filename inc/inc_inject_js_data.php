<?php
   require_once("./inc/inc_user_data.php");
?>
<script>
    const userData = <?php echo(json_encode(get_user_data_nopass(), JSON_HEX_TAG)); ?>;
    const currentUser = <?php echo(json_encode($_SESSION['user'], JSON_HEX_TAG)); ?>;
    const currentFriends = <?php echo(json_encode(get_friends($_SESSION['user']), JSON_HEX_TAG)); ?>;
    const friendRequests = <?php echo(json_encode(get_friend_requests($_SESSION['user']), JSON_HEX_TAG)); ?>;
</script>
<script src="./js/friend.js" defer></script>
<script src="./js/messaging.js" defer></script>