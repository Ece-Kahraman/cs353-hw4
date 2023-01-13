<!--
    Ece Kahraman
    21801879
    CS353-001
    
    PHP file for the home page of the customer, embedded into HTML
    Displays the customer's accounts, allows them to be closed
    Allows movement to the money transfer page, or allows log out
 -->

<?php    
    session_start();
    require('connection.php');
    
    $customerID = $_SESSION['cid'];
    $sql = " SELECT aid, branch, balance, openDate FROM owns NATURAL JOIN account WHERE cid = '$customerID'";
    $query = $connection->query($sql);
    $connection->close();

?>

<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset = "UTF-8">
    <title> BANK SYSTEM: Home </title>
</head>

<h1> Welcome, <?php echo $_SESSION['name']; ?>! </h1>
<body>

    <table>
        <tr>
            <th>Account ID</th>
            <th>Branch</th>
            <th>Balance</th>
            <th>Open Date</th>
        </tr>
        <?php  while($rows = $query->fetch_assoc()){
                    $id = $rows['aid'];
                    $brc = $rows['branch'];
                    $bln = $rows['balance'];
                    $dt = $rows['openDate']; ?>
        <tr>
            <td><?php echo $id;?></td>
            <td><?php echo $brc;?></td>
            <td><?php echo $bln;?></td>
            <td><?php echo $dt;?></td>
            <td></td>
            <td><a href="./close.php?data=<?php echo $id?>">Close</a></td>
        </tr>
        <?php } ?>
    </table>
    <a href="./transaction.php">Money Transaction</a>
    <a href="./login.php">Log Out</a>

</body>
</html>

