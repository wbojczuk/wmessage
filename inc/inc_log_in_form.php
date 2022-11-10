

    <?php

        if(isset($_POST["submit"])){
            
            require_once("./inc/inc_user_data.php");

           $errors = array();
            // CHECK NAMES
            $values = array(
                "Username" => strtolower(trim($_POST["username"])),
                "Password" => trim($_POST["password"])
            );

            if(empty($values["Username"]) || empty($values["Password"])){
                $errors[] = "Fields cannot be empty!";
            }else{

                if(!user_exists($values["Username"])){
                    $errors[] = "User does not exist";
                }else{
                    // Check Password
                    
                    $current_user = get_user($values["Username"]);
                    $current_password = $current_user[3];
                    $entered_password = hash("sha256", $values["Password"]);

                    if(!($current_password == $entered_password)){
                        $errors[] = "Incorrect password!";
                    }
                   
                }
            }

           

        //    PROCESS OR NO?
        if(count($errors) == 0){
        
            
                 session_start();
            $_SESSION["user"] = $values['Username'];

            header("Location:index.php");
            

        }else{
            ?>
                <h1 style=" margin-top: 10vh;">Log In</h1>
    <div class="center" style="width: 100%; margin-top: 10vh;">
        <form action="./index.php" method="POST">
            <div class="center">
                <label for="username">Username:</label><input type="text" name="username">
                <label for="password">Password:</label><input type="password" name="password">
            </div>
            <br>
            <div class="center">
            <input type="submit" name="submit" value="Log In!">
            </div>
        </form>
    </div>
            <div class="center">
        <div class="errors">
            <?php
                foreach($errors as $error){
                    echo "<span>$error</span><br>";
                }
            ?>
        </div>
        </div>
        <div class="center">
            <a class="sign-up-link" href="./index.php?action=signup">Don't have an account? Sign up!</a>
        </div>
    
            <?php
        }


        }else{
            ?>
            
            <h1 style=" margin-top: 10vh;">Log In</h1>
    <div class="center" style="width: 100%; margin-top: 10vh;">
        <form action="./index.php" method="POST">
            <div class="center">
                <label for="username">Username:</label><input type="text" name="username">
                <label for="password">Password:</label><input type="password" name="password">
            </div>
            <br>
            <div class="center">
            <input type="submit" name="submit" value="Log In!">
            </div>
        </form>
    </div>
    <div class="center">
            <a class="sign-up-link" href="./index.php?action=signup">Don't have an account? Sign up!</a>
        </div>
            
            <?php
        }
    ?>
