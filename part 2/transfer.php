<!--
    Ece Kahraman
    21801879
    CS353-001

    PHP file to update the balances of two given accounts
 -->

<?php
    session_start();
    require('connection.php');

    $fromID = $_SESSION['fromID'];
    $toID = $_SESSION['toID'];
    $amount = $_SESSION['amount'];

    $stmt = $connection->query(" SELECT balance FROM account WHERE aid = '$fromID' ");
    $fromBalance = ($stmt->fetch_assoc())['balance'];

    $stmt = $connection->query(" SELECT balance FROM account WHERE aid = '$toID' ");
    $toBalance = ($stmt->fetch_assoc())['balance'];

    $newFromBalance = $fromBalance - $amount;
    $newToBalance = $toBalance + $amount;

    $sqlFrom = " UPDATE account SET balance = '$newFromBalance' WHERE aid = '$fromID' ";
    $sqlTo = " UPDATE account SET balance = '$newToBalance' WHERE aid = '$toID' ";

    if($connection->query($sqlFrom) && $connection->query($sqlTo)) {
        header("Location: transaction.php");
    } else {
        echo "<script type='text/javascript'>alert('Transaction could not be performed!');</script>";
        header("Location: transaction.php");
    }

    $stmt->close();
    $connection->close();  
?>