<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Home Page</title>
    <link rel="icon" type="image/jpg" href="images/homepageimage.jpg">
    <link rel="stylesheet" href="css/usergamereccommendationscss.css">

</head>
<body style="background-color: gray;">

    <div id="header">
        <img src="images/homepageimage.jpg" style="width: 10%; margin-right: 5%;" alt="Image of Gaming PC.">
        Your Game Recommendations!
        <img src="images/homepageimage2.jpg" style="width: 15%; margin-left: 4%;" alt="Image of recommended parts.">
        <form action="loginpage.php">
            <input type="submit" value="Log In" />
        </form>
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
            <li><a href="partlinksfromuser.html">User Submitted Part Links</a></li>
        </ul>
    </div>

    <div id="bod">
        <div id="plform">
            <h2>Sumbit your own parts list!</h2>
            <form action="" method="post">
                <b>What Game would you like to add?: </b><input type="text" name="game_name"><br><br>
                <b>Share a short description of the game (500 characters): </b><br><textarea maxlength="500" rows="9" cols="100" name="game_desc"></textarea><br><br>
                <input type = "submit" value="submit" name="submit">
            </form>
            
            <?php
            if(isset($_POST["submit"])){
                if(!empty($_POST["game_name"])){
                    require_once('php/connect.php');
                    $sql = "INSERT INTO games (game_name, game_description) VALUES ('".$_POST["game_name"]."','".$_POST["game_desc"]."')";
                    if(mysqli_query($dbc, $sql)){
                        echo "Successfully added Game.";
                    } else{
                        echo( "ERROR:" . mysqli_error($dbc));
                    }
                    //mysqli_query($dbc,"INSERT INTO games (game_name, game_desc) VALUES ('".$_POST["game_name"]."','".$_POST["game_desc"]."')") or die(mysqli_error($dbc));
                }
            }
            ?>
        </div>

        <div id="glist">
            <?php
                require_once('php/connect.php');
                $sql = "SELECT game_id, game_name, game_description FROM games";

                $response = @mysqli_query($dbc, $sql);

                if($response){
                    echo '<h2>User shared games!</h2>';
                    while($row = mysqli_fetch_array($response)){
                        echo '<h2>Game '.$row['game_id']. ':</h2>
                        <ul style="list-style-type: none; font-size: 20px; vertical-align: middle;">
                        <li><b>Game Name:</b> '.$row['game_name'].'</li>
                        <li><b>Game Description:</b> '.$row['game_description'].'</li>
                        </ul>
                        ';
                    }
                }
                mysqli_close($dbc);
            ?>
        </div>
    </div>

    <div id="footer">
        Contact us: Mason Waters (watersmw7935@uwec.edu), Shane Falkum (falkumsm2838@uwec.edu)
    </div>

</body>
</html>