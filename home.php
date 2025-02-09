
<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <form action="home.php" method="post">
        <input type="text" name="post">
        <input type="submit" name="topost" value="POST"><br><br>
       <!-- <input type="submit" name="logout" value="Logout"> --> 
        

    </form>
</body>
</html>

<?php


if(isset($_POST["post"])){
    echo $_POST["post"];
}

?>