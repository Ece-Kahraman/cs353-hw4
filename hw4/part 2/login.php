<!--
    Ece Kahraman
    21801879
    CS353-001
    
    PHP file to log into the system, embedded into HTML
 -->

<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset = "UTF-8">
    <title> BANK SYSTEM: Login </title>
</head>

<h1> LOGIN </h1>
<body>

    <form method="post">
        <label for="name">Name:</label><br>
        <input type="text" name="name" id="name" required="required"/> <br><br>

        <label for="cid">Customer ID:</label><br>
        <input type="password" name="cid" id="cid" required="required"/> <br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
    
    require('connection.php');
    
    session_start();
    
    if( isset($_POST['name']) && isset($_POST['cid']) ) {
                
        if( $statement = $connection->prepare( "SELECT name, cid FROM customer WHERE name = ? and cid = ?")){
            
            $statement->bind_param( "ss", $_POST['name'], $_POST['cid']);

            
            if( $statement->execute()){

                if( $statement->fetch()){
                    $_SESSION['name'] = $_POST['name'];
                    $_SESSION['cid'] = $_POST['cid'];
                    header( "location: home.php");
                } else {
                    echo "<script type='text/javascript'>alert('Incorrect information!');</script>";
                }
            }
        }

        $statement->close();

    }
?>