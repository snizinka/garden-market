<head>
<link rel="stylesheet" href="styles.css">
</head>
<style>
       h4 {
            margin: 0px;
            margin-top: 14px;
       }

       .textcont {
              margin-left: 30px;
              margin-top: 10px;
              width: 540px;
       }

       .main {
              height: 100%;
              overflow: auto;
       }

       .numbers {
              display: flex;
       }
</style>

<?php
session_start();
require_once('categories.php');
echo "<div class='main'>";
if($_SESSION["auth"] != "true")
{
    header("Location: unsigned.php");
}

$db = mysqli_connect("localhost", "root", "", "wodz");

$ggg = 'SELECT od.orderId, od.amount, gds.goodsname, gds.goodscost, gds.goodsId FROM `order` as od
RIGHT JOIN goods as gds on gds.goodsId = od.goodsId
WHERE od.userId = '.$_SESSION["logged_userid"];


$result = mysqli_query($db, $ggg);
echo '<h1 style="text-align: center;">Корзина</h1>';
echo '<div class="container">';
while($myr = mysqli_fetch_array($result))
{
       echo '<form action="add.php?o='.$myr['orderId'].'" method="post">';
       echo '<div class="ordercard">';
       echo '<div class="textcont">';
       echo '<a href="card.php?i_id='.$myr['goodsId'].'" class="goodname">'.$myr['goodsname'].'</a>';
       echo '<div class="numbers"><h4 class="cst">Ціна:</h4><h4 class="ordercost">'.$myr['goodscost'].'</h4></div>';
       echo '<div class="numbers"><h4 class="amnt">Кількість:</h4> <h4 type="text" id="amount" class="orderamount">'.$myr['amount'].'</h4></div>';
       echo '</div>';
       echo '<input type="submit" class="orderadd" value="X">';
       echo '</div>';
       echo '</form>';
}
echo '</div>';
echo '</div>';

require('footer.php');
?>