<!-- SIGN UP PAGE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WMessage</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/friends.css">
    <link rel="stylesheet" href="css/mail.css">
</head>
<body>
<?php
// CREATE FOLDER HEIRARCHY IF NOT CREATED
if(!file_exists("./data")){
    mkdir("./data");
}
if(!file_exists("./data/friends")){
    mkdir("./data/friends");
}
if(!file_exists("./data/requests")){
    mkdir("./data/requests");
}
if(!file_exists("./data/users.txt")){
    file_put_contents("./data/users.txt", "");
}


session_start();

    // SET ACTION ATTRIBUTE
        $action = "";
        if(isset($_GET["action"])){
            $action = $_GET["action"];
        }

        // LOGOUT SESSION
        if(!empty($action) && $action == "logout"){
            session_start();
            session_destroy();
            header("Location:index.php");
        }

        // If Logged In
    if(isset($_SESSION["user"])){
        include("./inc/inc_home_page.php");
        ?>
        
        
    <?php
   
    } else{
        // IF Not Logged In
        if(!empty($action) && $action == "signup"){
            include("./inc/inc_sign_up_form.php");
        }else{
            include("./inc/inc_log_in_form.php");
        }
        
    }
    
?>
    
</body>
</html>