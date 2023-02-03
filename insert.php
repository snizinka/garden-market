<html>
<head>
<title>Товари</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<style>
    .textial {
        margin-left: 10px;
        width: 140px;
    }

    .textcont {
        width: 250px;
        margin-top: 23px;
        margin-left: 0px;
    }

    .iaddtocrd {
        margin-bottom: 30px;
    }

    h4 {
        width: 120px;
    }

    .icard {
        display: flex;
        width: 340px;
        margin: auto;
    }

    .icd {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 340px;
        border: solid orange 4px;
        border-radius: 10px;
    }
    
    .sbtn:hover {
        transition: .7s ease;
        cursor: pointer;
        background: orange;
        color: white;
    }

    .main {
        height: 100%;
        overflow: auto;
    }

    .imagecard {
        display: flex;
        width: 400px;
        height: 140px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border: solid orange 3px;
        border-radius: 10px;
    }

    .loadim {
        width: 90px;
        height: 40px;
        border: solid orange 3px;
        border-radius: 7px;
        margin-top: 70px;
    }

    .fadd {
        margin-top: 40px;
        margin-left: 30px;
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

if($_POST)
{
    if($_POST["gnam"] != null || $_POST["gamount"] != null || $_POST["gcost"] != null || $_POST["gdesc"] != null)
    {
        if($_POST["gnam"] == null || $_POST["gamount"] == null || $_POST["gcost"] == null || $_POST["gdesc"] == null)
        {
            echo "<h4 id='err3'>Заповніть всі поля</h4>";
        }else
        {
        echo '<form method="post" enctype="multipart/form-data">';
        echo '<div class="imagecard">';
        echo '<div class="textcont">';
        echo '<h4 style="width: 200px; text-align: center;">Зображення товару</h4>';
        echo '<input type="file" class="fadd" name="filez">';
        echo '</div>';
        echo '<input type="submit" class="loadim" value="Завантажити"></div></form>';


        $_SESSION["gnam"] = $_POST["gnam"];
        $_SESSION["gcost"] = $_POST["gcost"];
        $_SESSION["gdesc"] = $_POST["gdesc"];
        $_SESSION["gamount"] = $_POST["gamount"];
        $_SESSION["gcat"] = $_POST["gcat"];
        }
    }
    else
    {
        echo "<h4 id='err3'>Заповніть всі поля</h4>";
    }
}else if($_SESSION["gnam"] != "")
{
    if(!copy($_FILES['filez']['tmp_name'], 'D:/openserver/domains/localhost/images/'.$_FILES['filez']['name'].''))
    {
        echo "Виникла помилка";
        unset($_SESSION["gnam"]);
        unset($_SESSION["gcost"]);
        unset($_SESSION["gdesc"]);
        unset($_SESSION["gamount"]);
        unset($_SESSION["gcat"]);
        unset($_SESSION["goodsname"]);
        unset($_SESSION["categoryId"]);
        header("Location: insert.php");
    }
    else
    {
        $db = mysqli_connect("localhost", "root", "", "wodz");
        $ggg = 'INSERT INTO `goods`(`goodsname`, `goodscost`, `goodsdescription`, `goodsamount`, `categoryId`, `image`) VALUES ("'.$_SESSION["gnam"].'",'.$_SESSION["gcost"].',"'.$_SESSION["gdesc"].'",'.$_SESSION["gamount"].', '.$_SESSION["gcat"].', "'.$_FILES["filez"]["name"].'")';  
        mysqli_query ($db, $ggg);
        echo " ".$ggg;
        unset($_SESSION["gnam"]);
        unset($_SESSION["gcost"]);
        unset($_SESSION["gdesc"]);
        unset($_SESSION["gamount"]);
        unset($_SESSION["gcat"]);
        header("Location: insert.php");
    }
}
else
{
echo '<form method="post">';
       echo '<div class="icd">';
       echo '<div class="icard">';

       echo '<div class="textial">';
            echo '<h4 style="margin-bottom: 30px;
            margin-top: 20px;">Назва товару:</h4>';
            echo '<h4 style="margin-bottom: 30px;">Кількість товару:</h4>';
            echo '<h4 style="margin-bottom: 30px;">Ціна товару:</h4>';
            echo '<h4 style="margin-bottom: 30px;">Опис товару:</h4>';
            echo '<h4 style="margin-bottom: 30px;">Категорія товару:</h4>';
       echo '</div>';

       echo '<div class="textcont">';
       echo '<input type="text" class="iaddtocrd" name="gnam">';
       echo '<input type="text" class="iaddtocrd" name="gamount">';
       echo '<input type="text" class="iaddtocrd" name="gcost">';
       echo '<input type="text" class="iaddtocrd" name="gdesc">';
       echo '<select class="iaddtocrd" name="gcat">
                <option value="1">Сіялки</option>
                <option value="2">Топори, пили</option>
                <option value="3">Оприскувачі</option>
            </select>';
       echo '</div>';
       echo '</div>';

       echo '<input type="submit" class="sbtn" value="Додати товар">';
       echo '</div>';
echo '</form>';

}
echo '</div>';
require('footer.php');
?>

</body>
</html>