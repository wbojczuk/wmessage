
    <?php
        

        if(isset($_POST["submit"])){
            
            // CHECK IF USERNAME EXISTS
            require_once("./inc/inc_user_data.php");
            

           function validate_input(&$values, $key, $type, &$errors){
                $current_val = $values[$key];
                if(!empty($current_val)){

                    switch($type){
                        case "name":
                            if(!preg_match("/[a-z`]{1,34}/i",$current_val)){
                                $errors[] = "Enter a valid name in the \"$key\" field";
                                $values[$key] = "";
                            }
                        break;
                        case "pass":
                            if(!preg_match("/[^\s:;]{4,}/i", $current_val)){
                                $errors[] = "Enter a valid password with 4 or more characters";
                                $values[$key] = "";
                            }
                        break;
                        case "user":
                            if(!preg_match("/[a-z0-9]{1,34}/i",$current_val)){
                                $errors[] = "Enter a valid username with only letters and numbers";
                                $values[$key] = "";
                            }
                        break;
                        case "confpass":
                            if(($values[$key] !== $values["Password"])){
                                $errors[] = "Passwords Do Not Match!";
                            }
                        break;

                    }
                }else{
                    $errors[] = "$key Field Cannot Be Empty";
                    $val = "";
                }
           }



           $errors = array();
            // CHECK NAMES
            $values = array(
                "First Name" => trim($_POST["fName"]),
                "Last Name" => trim($_POST["lName"]),
                "Username" => trim($_POST["username"]),
                "Password" => trim($_POST["password"]),
                "Confirm Password" => trim($_POST["confirmpassword"])
            );

            if(user_exists($values["Username"]) === true){
                $errors[] = "Username is taken!";
            }

            validate_input($values, "First Name", "name", $errors);
            validate_input($values, "Last Name", "name", $errors);
            validate_input($values, "Username", "user", $errors);
            validate_input($values, "Password", "pass", $errors);
            validate_input($values, "Confirm Password", "confpass", $errors);

        //    PROCESS OR NO?
        if(count($errors) == 0){
            $hashed_password = hash("sha256", $values["Password"]);
            $new_user = "{$values['Username']}:{$values['First Name']}:{$values['Last Name']}:$hashed_password;";
            file_put_contents("./data/users.txt", $new_user, FILE_APPEND);
            file_put_contents("./data/friends/{$values['Username']}.txt", "");
            file_put_contents("./data/requests/{$values['Username']}.txt", "");
            
            
            session_start();
            $_SESSION["user"] = $values['Username'];

            header("Location:index.php");

        }else{
            ?>
                <h1 style=" margin-top: 10vh;">Sign Up</h1>
    <div class="center" style="width: 100%; margin-top: 10vh;">
        <form action="./index.php?action=signup" method="POST">
        
            <div class="between">
                <span><label for="username">Username:</label><input value="<?php echo($values["Username"]); ?>" type="text" name="username"></span>
            </div>
            <br>
            <div class="between">
            <span><label for="fName">First Name:</label><input value="<?php echo($values["First Name"]); ?>" type="text" name="fName"></span>
            <span><label for="lName">Last Name:</label><input value="<?php echo($values["Last Name"]); ?>" type="text" name="lName"></span>
            </div>
            <br>
            <div class="between">
                <span><label for="password">Password:</label><input value="<?php echo($values["Password"]); ?>" type="password" name="password"></span>
                <span><label for="confirmpassword">Confirm Pass:</label><input value="<?php echo($values["Confirm Password"]); ?>" type="password" name="confirmpassword"></span>
            </div>
            <br>
            <div class="center">
            <input type="submit" name="submit" value="Sign Up!">
            </div>
        </form>
    </div>
    <div class="center">
            <a href="./index.php?">Already have an account? Log in!</a>
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
    
            <?php
        }


        }else{
            ?>
            
            <h1 style=" margin-top: 10vh;">Sign Up</h1>
    <div class="center" style="width: 100%; margin-top: 10vh;">
        <form action="./index.php?action=signup" method="POST">
        
            <div class="between left">
                <span>
            <label for="username">Username:</label><input type="text" name="username">
            </span>
            </div>
            <br>
            <div class="between">
                <span><label for="fName">First Name:</label><input type="text" name="fName"></span>
                <span><label for="lName">Last Name:</label><input type="text" name="lName"></span>
            </div>
            <br>
            <div class="between">
                <span><label for="password">Password:</label><input type="password" name="password"></span>
                <span><label for="password">Confirm Pass:</label><input type="password" name="confirmpassword"></span>
            </div>
            
            <br>
            <div class="center">
            <input type="submit" name="submit" value="Sign Up!">
            </div>
        </form>
    </div>
    <div class="center">
            <a href="./index.php?">Already have an account? Log in!</a>
        </div>
            <?php
        }
    ?>
