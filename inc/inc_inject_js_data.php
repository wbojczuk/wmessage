<?php
   require_once("./inc/inc_user_data.php");
?>
<script>
    const userData = <?php echo(json_encode(get_user_data_nopass(), JSON_HEX_TAG)); ?>;
</script>
<script src="./js/script.js" defer></script>