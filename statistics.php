<header>
<link rel="stylesheet" href="styles.css">
</header>

<style>
    .imag {
    height: 170px;
    width: 700px;
    margin: auto;
    margin-bottom: 30px;
    border: solid orange 3px;
    border-radius: 7px;
}

.prefix {
    margin: 0px;
    margin-left: 20px;
    margin-right: 20px;
    margin-bottom: 5px;
    color: beige;
    font-size: 30px;
    margin-top: 32px;
}

.sh4 {
    margin-top: 38px;
    padding: 0px;
    color: darkblue;
    font-size: 27px;
    margin-bottom: 0px;
}

.main {
    height: 100%;
    overflow: auto;
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

if($_SESSION['role'] != "admin")
{
    header("Location: index.php");
}else
{

$db = mysqli_connect("localhost", "root", "", "wodz");

$ggg = 'SELECT st.statsviews, ct.categoryname FROM `stats` as st
RIGHT JOIN category as ct on ct.categoryId = st.categoryId';
echo '<center><h1>Статистика</h1></center>';

$result = mysqli_query ($db, $ggg);

echo '<div class="container">';
while($myr = mysqli_fetch_array($result))
{

echo '<div class="imag">';
echo '<div class="doub">';
echo '<h4 class="prefix">Категорія товару:</h4><h4 class="sh4">'.$myr['categoryname'].'</h4>';
echo '</div>';
echo '<div class="doub">';
echo '<h4 class="prefix">Кількість переглядів:</h4><h4 class="sh4">'.$myr['statsviews'].'</h4>';
echo '</div>';
echo '</div>';
}
echo '</div>';
}
echo '</div>';

require('footer.php');
?>