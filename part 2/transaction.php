<!--
    Ece Kahraman
    21801879
    CS353-001
    
    PHP file for the money transfer page, embedded into HTML
    Displays the customer's own accounts, and the all accounts in the system
    Takes two account IDs and some amount of money for the transaction
    Appropriate warnings are implemented
 -->

<?php
    require('connection.php');
    session_start();

    if(isset($_POST['submit']) && isset($_POST['fromID']) && isset($_POST['toID']) && isset($_POST['amount'])) {
        $fromAID = $_POST['fromID'];
        $toAID = $_POST['toID'];
        $amount = $_POST['amount'];
        $customerID = $_SESSION['cid'];

        $stmt = $connection->query(" SELECT balance, cid FROM account NATURAL JOIN owns WHERE aid = '$fromAID' ");
        $fromBalance = ($stmt->fetch_assoc())['balance'];
        $fromCID = ($stmt->fetch_assoc())['cid'];

        $stmt = $connection->query(" SELECT balance FROM account WHERE aid = '$toAID' ");
        $toBalance = ($stmt->fetch_assoc())['balance'];

        if( $fromAID == $toAID ){
            echo "<script type='text/javascript'>alert('Can not transfer money to the same account!');</script>";
        } else if( $amount < 0 || $amount > $fromBalance ){
            echo "<script type='text/javascript'>alert('Enter a number between 0 and the balance of your account!');</script>";
        } else if( $fromCID != $customerID ) {
            echo "<script type='text/javascript'>alert('You can not update an account not belonging to you!');</script>";
        } else {
            $_SESSION['fromID'] = $_POST['fromID'];
            $_SESSION['toID'] = $_POST['toID'];
            $_SESSION['amount'] = $_POST['amount'];
            header("Location: transfer.php");
        }

    }
       
?>

<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset = "UTF-8">
    <title> BANK SYSTEM: Transaction </title>
</head>

<body>
    <h1> Transaction! </h1>

    <div>
        <div>
            <p style="font-weight:bold;font-size:125%;">Your Accounts</p>
            
            <table>
                
                <tr>
                    <th>Account ID</th>
                    <th>Branch</th>
                    <th>&nbsp;Balance</th>
                </tr>
                <form>
                    <?php  
                        $customerID = $_SESSION['cid'];
                        $query1 = $connection->query(" SELECT aid, branch, balance FROM owns NATURAL JOIN account WHERE cid = '$customerID'");
                        while($fromRows = $query1->fetch_assoc()){ ?>
                        <tr style="text-align:center;">
                            <td><?php echo $fromRows['aid'];?></td>
                            <td>&nbsp;<?php echo $fromRows['branch'];?></td>
                            <td>&nbsp;<?php echo $fromRows['balance'];?></td>
                        </tr>
                    <?php } ?>
                </form>
            </table>
        </div>
        
        <br><br>

        <div>
            <p style="font-weight:bold;font-size:125%;">All Accounts</p>

            <table>            
                <tr>
                    <th>Account ID</th>
                    <th>Branch</th>
                    <th>&nbsp;Balance</th>
                    <th>&nbsp;Account Owner</th>
                </tr>
                <form>
                    <?php 
                        $query2 = $connection->query(" SELECT aid, branch, balance, name FROM customer NATURAL JOIN owns NATURAL JOIN account");
                        while($toRows = $query2->fetch_assoc()){ ?>
                        <tr style="text-align:center;">
                            <td><?php echo $toRows['aid'];?></td>
                            <td>&nbsp;<?php echo $toRows['branch'];?></td>
                            <td>&nbsp;<?php echo $toRows['balance'];?></td>
                            <td>&nbsp;<?php echo $toRows['name'];?></td>
                        </tr>
                    <?php } ?>
                </form>
            </table>
        </div>
    </div>  

    <br><br>

    <form method="post">
        <label for="fromID">Enter the account ID to send from:</label>
        <input name="fromID" id="fromID" required="required"/> <br><br>

        <label for="toID">Enter the account ID to send to:</label>
        <input name="toID" id="toID" required="required"/> <br><br>

        <label for="amount">Enter the amount of money:</label>
        <input type="number" name="amount" id="amount" required="required"/> <br><br>

        <input type="submit" name="submit" value="submit">
    </form>

    <a href="./home.php">Back</a>
    <a href="./login.php">Log Out</a>

</body>
</html>
