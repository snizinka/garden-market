<header>
<link rel="stylesheet" href="styles.css">
</header>
<style>
h4 {
    margin: 0;
    font-size: 14px;
    margin-top: 5px;
    margin-bottom: 5px;
}
.cindxgood {
    color: blueviolet;
    text-align: center;
    margin: 0;
    font-size: 15px;
    font-family: sans-serif;
    height: 40px;
}

.indxtextcrd {
    width: 160px;
    height: 80px;
    margin: auto;
    margin-bottom: 10px;
}

.row {
    display: flex;
    margin-bottom: 30px;
}

.imgindx:hover {
    transition: .3s ease;
    width: 200px;
    height: 320px;
    margin-left: -10px;
}

.goodsubm:hover {
    transition: .7s ease;
    background: orange;
    color: white;
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

if($_GET['category'] == 1)
{
    $ggg = 'SELECT gd.goodsId, gd.goodsname, gd.goodscost, gd.goodsdescription, gd.goodsamount, gd.image, ct.categoryname FROM goods as gd 
    RIGHT JOIN category as ct on ct.categoryId = gd.categoryId
    WHERE ct.categoryId = 1';

    $update = 'UPDATE stats set statsviews = statsviews + 1 WHERE statsId = 1;';
    echo '<center><h1>Сіялки</h1></center>';
}
else if($_GET['category'] == 2)
{
    $ggg = 'SELECT gd.goodsId, gd.goodsname, gd.goodscost, gd.goodsdescription, gd.goodsamount, gd.image, ct.categoryname FROM goods as gd 
    RIGHT JOIN category as ct on ct.categoryId = gd.categoryId
    WHERE ct.categoryId = 2';

    $update = 'UPDATE stats set statsviews = statsviews + 1 WHERE statsId = 2;';
    echo '<center><h1>Топори, пили</h1></center>';
}
else if($_GET['category'] == 3)
{
    $ggg = 'SELECT gd.goodsId, gd.goodsname, gd.goodscost, gd.goodsdescription, gd.goodsamount, gd.image, ct.categoryname FROM goods as gd 
    RIGHT JOIN category as ct on ct.categoryId = gd.categoryId
    WHERE ct.categoryId = 3';
    $update = 'UPDATE stats set statsviews = statsviews + 1 WHERE statsId = 3;';
    echo '<center><h1>Оприскувачі</h1></center>';
}
else if($_GET['search'] == 1)
{
    if($_POST["fcost"] != "" && $_POST["fcost"] != null)
    {
        $ggg = 'SELECT gd.goodsId, gd.goodsname, gd.goodscost, gd.goodsdescription, gd.goodsamount, gd.image, ct.categoryname FROM goods as gd 
        RIGHT JOIN category as ct on ct.categoryId = gd.categoryId
        WHERE gd.goodsname LIKE "%'.$_POST['searchby'].'%" AND gd.goodscost <= '.$_POST["fcost"].'';
    }else{
        $ggg = 'SELECT gd.goodsId, gd.goodsname, gd.goodscost, gd.goodsdescription, gd.goodsamount, gd.image, ct.categoryname FROM goods as gd 
        RIGHT JOIN category as ct on ct.categoryId = gd.categoryId
        WHERE gd.goodsname LIKE "%'.$_POST['searchby'].'%"';
    }
}
else
{
    $ggg = 'SELECT gd.goodsId, gd.goodsname, gd.goodscost, gd.goodsdescription, gd.goodsamount, gd.image, ct.categoryname FROM goods as gd RIGHT JOIN actual as al on gd.goodsId = al.goodsId RIGHT JOIN category as ct on ct.categoryId = gd.categoryId';
    echo '<center><h1>Актуальне</h1></center>';
}


$result = mysqli_query ($db, $ggg);

if($update != "")
{
    $updt = mysqli_query ($db, $update);
}

$countance = 0;

echo '<div class="container">';
while($myr = mysqli_fetch_array($result))
{
    if($countance % 4 == 0)
    {
        echo '<div class="row">';
        $countance = 0;
    }
$ID = 'card.php?i_id='.$myr["goodsId"];
echo '<form action='.$ID.' method="post" style="height: 324px;">';
echo '<div class="card" style="height: 330px;">';
echo '<div class="indximag">';
echo '<img class="imgindx" src="images/'.$myr["image"].'">';
echo'</div>';
echo '<div class="indxtextcrd">';
echo '<h3 class="cindxgood">'.$myr["goodsname"].'</h3>';
echo '<h4>'.$myr['goodscost'].' грн</h4>';
echo '<h4>'.$myr['categoryname'].'</h4>';
echo '</div>';
echo '<input type="submit" class="goodsubm" value="Оглянути"></input>';
echo '</div>';
echo '</form>';
$countance += 1;
if($countance % 4 == 0)
{
    echo '</div>';
}
}
echo '</div>';
echo '</div>';
echo '</div>';

require('footer.php');
?>