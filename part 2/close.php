<!--
    Ece Kahraman
    21801879
    CS353-001
    
    PHP file to close a chosen account
 -->

<?php
    session_start();
    require('connection.php');

    $accountID = $_GET['data'];
    $sql1 = " DELETE FROM owns WHERE aid = '$accountID'";
    $sql2 = " DELETE FROM account WHERE aid = '$accountID'";
    if($connection->query($sql1) && $connection->query($sql2)) {
        header("Location: home.php");
    } else {
        echo "<script type='text/javascript'>alert('Account . $accountID . can not be closed!');</script>";
        header("Location: home.php");
    }
    $connection->close();   
?>
