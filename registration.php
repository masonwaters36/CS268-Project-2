<?php
    require_once "php/connect.php";
    $user = "";
    $pass = "";
    $re_pass = "";
    $user_out = "";
    $pass_out = "";
    $re_pass_out = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!empty(trim($_POST["email"]))){
            $sql = "SELECT user_id FROM users WHERE username = ?";
            
            $email = trim($_POST["email"]);

            $stmt = mysqli_prepare($dbc, $sql);

            if($stmt){
                mysqli_stmt_bind_param($stmt, "s", $email);

                if(mysqli_stmt_execute($stmt)){

                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) > 0){
                        $user_out = "There is already an account with this email.";
                    }
                    else{
                        $user = $email;
                    }
                }
            }
            else{
                echo "Couldn't connect to the database.";
            }
            mysqli_stmt_close($stmt);
        }
        else{
            $user_out = "Enter your Email.";
        }
        if(!empty(trim($_POST["password"]))){
            if(strlen(trim($_POST["password"]))<8){
                $pass_out = "Password must be at least 8 characters long.";
            }
            else{
                $pass = trim($_POST["password"]);
            }
        }
        else{
            $pass_out = "Enter your Password.";
        }
        if(!empty(trim($_POST["re-password"]))){
            $re_pass = trim($_POST["re-password"]);
            if(!empty($pass) && $re_pass != $pass){
                $re_pass_out = "Passwords do not match.";
            }
        }
        else{
            $re_pass_out = "Reconfirm Password.";
        }

        if(empty($user_out) && empty($pass_out) && empty($re_pass_out)){
            $sql = "INSERT INTO users (username, password) VALUES (?,?)";

            $stmt = mysqli_prepare($dbc, $sql);
            if($stmt){
                $db_user = $user;
                $db_pass = password_hash($pass, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ss", $db_user, $db_pass);
                if(mysqli_stmt_execute($stmt)){
                    echo "Account Registration Successful. You can now login!";
                }
                else{
                    echo "Database error.";
                }
            }
            mysqli_stmt_close($stmt);

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
    <link rel="stylesheet" href="css/registration.css">

</head>
<body style="background-color: gray;">

    <div id="header">
        <img src="images/homepageimage.jpg" style="width: 10%; margin-right: 5%;" alt="Image of Gaming PC.">
        How to Build a PC!
        <img src="images/homepageimage2.jpg" style="width: 15%; margin-left: 4%;" alt="Image of recommended parts.">
    </div>

    <div id="bod">
        <h1 style="text-align: center;">Sign Up!</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="registration-form">
            <?php
                if(!empty($user_out)){
                    echo $user_out;
                }
            ?>
            <input type="text" name="email" id="email-field" class="register-form-field" placeholder="Email">
            <?php
                if(!empty($pass_out)){
                    echo $pass_out;
                }
            ?>
            <input type="password" name="password" id="password-field" class="register-form-field" placeholder="Password">
            <?php
                if(!empty($re_pass_out)){
                    echo $re_pass_out;
                }
            ?>
            <input type="password" name="re-password" id="re-password-field" class="register-form-field" placeholder="Re-enter Password">

            <input type="submit" value="Register" id="register-form-submit">
        </form>
        <form action="loginpage.html">
            Have an account? Log in here: <input type="submit" value="Log In">
        </form>
        <a style="text-align: center;" href="homepage.html">Back to Home Page</a>
    </div>

    <div id="footer">
        Contact us: Mason Waters (watersmw7935@uwec.edu), Shane Falkum (falkumsm2838@uwec.edu)
    </div>

</body>
</html>