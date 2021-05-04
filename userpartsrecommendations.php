<php?
    session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>User Part Recommendations</title>
    <link rel="icon" type="image/jpg" href="images/homepageimage.jpg">
    <link rel="stylesheet" href="css/userpartreccommendationscss.css">

</head>
<body style="background-color: gray;">

    <div id="header">
        <img src="images/homepageimage.jpg" style="width: 10%; margin-right: 5%;" alt="Image of Gaming PC.">
        User Part Recommendations
        <img src="images/homepageimage2.jpg" style="width: 15%; margin-left: 4%;" alt="Image of recommended parts.">
        <?php
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true){
                echo '<form action="logout.php">
                <div style="font-size:20px;">Hello '.$_SESSION["user"].'! </div><input type="submit" value="log out"> 
                </form>';
            }
            else{
                echo '<form action="loginpage.php">
                <input type="submit" value="Log In" />
                </form>';
            }
        ?>
        
    </div>

    <div id = "nav">
        <ul style="list-style: none; padding-left: 0px;">
            <li><a href="homepage.html">Home Page</a></li>
            <li><a href="howtobuildapc.html">How to Build a PC</a></li>
            <li><a href="helpfullinks.html">Helpful Links</a></li>
            <li><a href="faq.html">Frequently Asked Questions</a></li>
            <li><a href="partsrecommendations.html">Parts Recommendations</a></li>
            <li><a href="gamingcompetitions.html">Gaming Competitions</a></li>
            <li><a href="personalbuilds.html">Personal Builds</a></li>
            <li><a href="typesofbuilds.html">Types of Builds</a></li>
            <li><a href="gamestobuy.html">Games to Buy</a></li>
            <li><a href="commonmistakes.html">Common Mistakes</a></li>
            <li><a href="userpartsrecommendations.php">User Part Recommendations</a></li>
            <li><a href="usergamerecommendations.php">User Game Recommendations</a></li>
            <li><a href="partlinksfromuser.php">User Submitted Part Links</a></li>
        </ul>
    </div>

    <div id="bod">
        <div id="plform">
            <h2>Sumbit your own parts list!</h2>
            <form action="" method="post">
                <b>Enter CPU: </b><input type="text" name="cpu" required><br><br>
                <b>Enter Motherboard: </b><input type="text" name="motherboard" required><br><br>
                <b>Enter GPU: </b><input type="text" name="gpu" required><br><br>
                <b>Enter Memory: </b><input type="text" name="memory"><br><br>
                <b>Enter Storage: </b><input type="text" name="str"><br><br>
                <b>Enter Power Supply: </b><input type="text" name="psu"><br><br>
                <b>Enter Case: </b><input type="text" name="box"><br><br>
                <input type = "submit" value="submit" name="submit">
            </form>
            
            <?php
            if(isset($_POST["submit"])){
                if(!empty($_POST["cpu"]) && !empty($_POST["motherboard"]) && !empty($_POST["gpu"])){
                    require_once('php/connect.php');
                    $sql = "INSERT INTO partslist (user, cpu, motherboard, gpu, memory, storage, psu, box) VALUES ('','".$_POST["cpu"]."','".$_POST["motherboard"]."','".$_POST["gpu"]."','".$_POST["memory"]."','".$_POST["str"]."','".$_POST["psu"]."','".$_POST["box"]."')";
                    if(mysqli_query($dbc, $sql)){
                        echo "Successfully added build.";
                    } else{
                        echo "ERROR:" . mysqli_error($dbc);
                    } 
                }
            }
            ?>
        </div>

        <div id="plist">
            <?php
                require_once('php/connect.php');
                $sql = "SELECT pl_id, cpu, motherboard, gpu, memory, storage, psu, box FROM partslist";

                $response = @mysqli_query($dbc, $sql);

                if($response){
                    echo '<h2>User submited lists!</h2>';
                    while($row = mysqli_fetch_array($response)){
                        echo '<h2>Parts list '.$row['pl_id']. ':</h2>
                        <ul style="list-style-type: none; font-size: 20px; vertical-align: middle;">
                        <li><b>CPU:</b> '.$row['cpu'].'</li>
                        <li><b>Motherboard:</b> '.$row['motherboard'].'</li>
                        <li><b>Graphics Card:</b> '.$row['gpu'].'</li>
                        <li><b>Memory:</b> '.$row['memory'].'</li>
                        <li><b>Storage:</b> '.$row['storage'].'</li>
                        <li><b>Power Supply:</b> '.$row['psu'].'</li>
                        <li><b>Case:</b> '.$row['box'].'</li>
                        </ul>
                        ';
                    }
                }
                mysqli_close($dbc);
            ?>
        </div>
    </div>

    <div id="footer">
        <div id="contact">Contact us:</div>
        <div class="name">Mason Waters<div class="email">(watersmw7935@uwec.edu)</div></div><div class="name">Shane Falkum<div class="email">(falkumsm2838@uwec.edu)</div></div>
    </div>

</body>
</html>