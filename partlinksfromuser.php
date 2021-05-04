<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Part Links From User</title>
    <link rel="icon" type="image/jpg" href="images/homepageimage.jpg">
    <link rel="stylesheet" href="css/partlinkscss.css">

</head>
<body style="background-color: gray;">

    <div id="header">
        <img src="images/homepageimage.jpg" style="width: 10%; margin-right: 5%;" alt="Image of Gaming PC.">
        Parts you've seen in Stock!
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
            <li><a href="partlinksfromuser.php">User Submitted Part Links</a></li>
        </ul>
    </div>

    <div id="bod">
        <div id="plform">
            <h2>Have you found a part in stock during this current shortage? Share here!</h2>
            <form action="" method="post">
                <b>What part did you find?: </b><input type="text" name="part_name"><br><br>
                <b>Enter link to part: </b><br><textarea rows="9" cols="100" name="part_link"></textarea><br><br>
                <input type = "submit" value="submit" name="submit">
            </form>
            
            <?php
            if(isset($_POST["submit"])){
                if(!empty($_POST["part_name"])){
                    require_once('php/connect.php');
                    $sql = "INSERT INTO links (part_name, part_link) VALUES ('".$_POST["part_name"]."','".$_POST["part_link"]."')";
                    if(mysqli_query($dbc, $sql)){
                        echo "Successfully added Game.";
                    } else{
                        echo( "ERROR:" . mysqli_error($dbc));
                    }
                }
            }
            ?>
        </div>

        <div id="glist">
            <?php
                require_once('php/connect.php');
                $sql = "SELECT game_id, part_name, part_link FROM links";

                $response = @mysqli_query($dbc, $sql);

                if($response){
                    echo '<h2>User shared links!</h2>';
                    while($row = mysqli_fetch_array($response)){
                        echo '<h2>Part '.$row['game_id']. ':</h2>
                        <ul style="list-style-type: none; font-size: 20px; vertical-align: middle;">
                        <li><b>Part Name:</b> '.$row['part_name'].'</li>
                        <li><b>Part Link:</b> <a href="'.$row['part_link'].'">Link to the part!</a></li>
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