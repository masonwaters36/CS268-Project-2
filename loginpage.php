<?php

    session_start();

    require_once "php/connect.php";
    $id = "";
    $user = "";
    $pass = "";
    $user_out = "";
    $pass_out = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!empty(trim($_POST["email"])) && !empty(trim($_POST["password"]))){
            $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
            

            $user = trim($_POST["email"]);
            $pass = $_POST["password"];
            

            $stmt = mysqli_prepare($dbc, $sql);

            if($stmt){
                mysqli_stmt_bind_param($stmt, "s", $user);

                if(mysqli_stmt_execute($stmt)){

                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) > 0){
                        mysqli_stmt_bind_result($stmt, $id, $db_user, $db_pass);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($pass, $db_pass)){
                                session_start();

                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["user"] = $user;

                                header("Location: homepage.html");
                            }
                            else{
                                $pass_out = "Password incorrect.";
                            }
                        }
                    }
                    else{
                        $user_out = "There is no account associated with this email.";
                    }
                }
            }
            else{
                echo "Couldn't connect to the database.";
            }
            mysqli_stmt_close($stmt);
        }
        else{
            $user_out = "Please fill all fields.";
        }
    }


    mysqli_close($dbc);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Home Page</title>
    <link rel="icon" type="image/jpg" href="images/homepageimage.jpg">
    <link rel="stylesheet" href="css/loginpagecss.css">

</head>
<body style="background-color: gray;">

    <div id="header">
        <img src="images/homepageimage.jpg" style="width: 10%; margin-right: 5%;" alt="Image of Gaming PC.">
        How to Build a PC!
        <img src="images/homepageimage2.jpg" style="width: 15%; margin-left: 4%;" alt="Image of recommended parts.">
        <?php
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true){
                echo '<form action="logout.php">
                <div style="font-size:20px;">Hello '.$_SESSION["user"].'! </div><input type="submit" value="log out"> 
                </form>';
            }
        ?>
    </div>

    <div id="bod">
        <h1 style="text-align: center;">Log in to our Website!</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="login-form">
            <?php
                if(!empty($user_out)){
                    echo $user_out;
                }
            ?>
            <input type="text" name="email" id="email-field" class="login-form-field" placeholder="Email">
            <?php
                if(!empty($pass_out)){
                    echo $pass_out;
                }
            ?>
            <input type="password" name="password" id="password-field" class="login-form-field" placeholder="Password">
            <input type="submit" value="Login" id="login-form-submit">
        </form>
        <form action="registration.php">
            Don't have an account? Register here: <input type="submit" value="Register" />
        </form>
        <a style="text-align: center;" href="homepage.html">Back to Home Page</a>
    </div>

    <div id="footer">
        
        Contact us: Mason Waters (watersmw7935@uwec.edu), Shane Falkum (falkumsm2838@uwec.edu)
    </div>

</body>
</html>