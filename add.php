<style>
    h4 {
        margin: 0px;
        color: beige;
    }

    .double {
        display: flex;
    }

    .prefix {
        margin-left: 20px;
        margin-right: 20px;
        margin-bottom: 5px;
    }

    .imag {
        width: 300px;
        margin: auto;
        margin-bottom: 30px;
        border: solid orange 3px;
        border-radius: 7px;
    }
</style>

<?php
session_start();
require_once('categories.php');
if($_SESSION["auth"] != "true")
{
    header("Location: unsigned.php");
}

if(isset($_SESSION['cardId']) && isset($_SESSION['logged_userid']))
{
    $db = mysqli_connect("localhost", "root", "", "wodz");
    $ggg = 'SELECT * FROM `order` WHERE userId = '.$_SESSION['logged_userid'].' AND goodsId = '.$_SESSION['cardId'].'';
    $result = mysqli_query ($db, $ggg);
    $myr = mysqli_fetch_array($result);


    if(isset($_GET["o"]))
    {
        $ggg = 'DELETE FROM `order` WHERE orderId = '.$_GET["o"].'';
        $result = mysqli_query ($db, $ggg);
        exit();
    }

    if($myr['amount'] == "")
    {
        $ggg = 'INSERT INTO `order`(`amount`, `userId`, `goodsId`) VALUES ('.$_POST["amount"].', '.$_SESSION['logged_userid'].', '.$_SESSION['cardId'].')';
        mysqli_query ($db, $ggg);
    }
    header("Location: order.php");
}

?>