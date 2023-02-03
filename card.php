<header>
<link rel="stylesheet" href="card.css">
</header>

<?php
session_start();
require('categories.php');
echo "<div class='main'>";

if($_SESSION["auth"] != "true")
{
    header("Location: unsigned.php");
}

if($_POST)
{
       $USER_ID = $_SESSION['logged_userid'];
       
       if($_POST['commen'] != "")
       {
           date_default_timezone_set('UTC');
           $db = mysqli_connect("localhost", "root", "", "wodz");
           $ggg= 'INSERT INTO `comments`(`commentContent`, `userId`, `goodsId`, `commentTime`) VALUES ("'.$_POST['commen'].'","'.$USER_ID.'","'.$_SESSION['cardId'].'", "'. date("Y-m-d H:i:s").'")';
           mysqli_query ($db, $ggg);
           header("Location: card.php?i_id=".$_GET['i_id']."");
       }
       else if(isset($_POST["edit"]))
       {
              $_SESSION['cardId'] = $_GET['i_id'];
       
              $db = mysqli_connect("localhost", "root", "", "wodz");
       
       
              $ggg= 'SELECT gd.goodsId, gd.goodsname, gd.goodscost, gd.goodsdescription, gd.goodsamount, gd.image, ct.categoryname FROM goods as gd
              RIGHT JOIN category as ct on ct.categoryId = gd.categoryId
              WHERE gd.goodsId ='.$_GET['i_id'];
              $result = mysqli_query ($db, $ggg);
       
              echo '<div class="container">';
              while($myr = mysqli_fetch_array($result))
              {
                     if($myr['categoryname'] == "Сіялки")
                     {
                            $update = 'UPDATE stats set statsviews = statsviews + 1 WHERE statsId = 1;';
                     }else if($myr['categoryname'] == "Топори, пили")
                     {
                            $update = 'UPDATE stats set statsviews = statsviews + 1 WHERE statsId = 2;';
                     }
                     else{
                            $update = 'UPDATE stats set statsviews = statsviews + 1 WHERE statsId = 3;';
                     }
              
                     $updt = mysqli_query ($db, $update);
       
                     echo '<form method="post">';
                     echo '<div class="card">';
                     echo '<div class="imag">';
                     echo '<img style="height: 350px; width: 260px;" src="images/'.$myr["image"].'">';
                     echo'</div>';
       
                     echo '<div class="edittextcont">';
                     echo '<div class="edith">
                            <h4>Назва товару:</h4>
                            <h4>Ціна:</h4>
                            <h4>Категорія товару:</h4>
                            <h4>Опис товару</h4>
                            </div>';

                     echo '<div class="editnumbers">
                     <input type="text" name="editname" class="editfield" value="'.$myr['goodsname'].'" />
                     <input type="text" name="editcost" class="editfield" value="'.$myr['goodscost'].'" />
                     <select class="editfield" name="editcat">
                            <option value="1" '.($myr['categoryname'] == "Сіялки" ? "selected" : "" ).'>Сіялки</option>
                            <option value="2" '.($myr['categoryname'] == "Топори, пили" ? "selected" : "" ).'>Топори, пили</option>
                            <option value="3" '.($myr['categoryname'] == "Оприскувачі" ? "selected" : "" ).'>Оприскувачі</option>
                     </select>
                     <input type="text" name="editdesc" class="editfield" value="'.$myr['goodsdescription'].'"/>
                     </div>';
                     echo '</div>';
                     echo '<div>';
                     echo '<input type="submit" name="editedit" class="editedit" value="Редагувати">';
                     echo '<input type="submit" name="editremove" class="editremove" value="Видалити" style=" width: 89px;
                     height: 40px;
                     border: solid red 2px;
                     border-radius: 10px;
                     cursor: pointer;
                     margin-left: 65px;
                     transition: .7s ease;
                     font-weight: bold;
                     margin-top: 10px;">';
                     echo '</div>';
                     echo '</div>';
                     echo '</form>';
              }
       }
       else if(isset($_POST["editremove"]))
       {
              $_SESSION['cardId'] = $_GET['i_id'];
              $db = mysqli_connect("localhost", "root", "", "wodz");
              $ggg= 'DELETE FROM `goods` WHERE goodsId = '.$_GET["i_id"].''; 
              $result = mysqli_query ($db, $ggg);
              header("Location: index.php");
       }
       else if(isset($_POST["editedit"]))
       {
              $_SESSION['cardId'] = $_GET['i_id'];
              $db = mysqli_connect("localhost", "root", "", "wodz");
              $ggg= 'UPDATE `goods` SET `goodsname`="'.$_POST["editname"].'",`goodscost`='.$_POST["editcost"].',`goodsdescription`="'.$_POST["editdesc"].'",`categoryId`='.$_POST["editcat"].' WHERE goodsId = '.$_GET["i_id"].''; 
              $result = mysqli_query ($db, $ggg);
              header("Location: card.php?i_id=".$_GET['i_id']."");
       }
}else
{
       $_SESSION['cardId'] = $_GET['i_id'];
       $db = mysqli_connect("localhost", "root", "", "wodz");

       $ggg= 'SELECT gd.goodsId, gd.goodsname, gd.goodscost, gd.goodsdescription, gd.goodsamount, gd.image, ct.categoryname FROM goods as gd
       RIGHT JOIN category as ct on ct.categoryId = gd.categoryId
       WHERE gd.goodsId ='.$_GET['i_id'];
       $result = mysqli_query ($db, $ggg);

       echo '<div class="container">';
       while($myr = mysqli_fetch_array($result))
       {
              if($myr['categoryname'] == "Сіялки")
              {
                     $update = 'UPDATE stats set statsviews = statsviews + 1 WHERE statsId = 1;';
              }else if($myr['categoryname'] == "Топори, пили")
              {
                     $update = 'UPDATE stats set statsviews = statsviews + 1 WHERE statsId = 2;';
              }
              else{
                     $update = 'UPDATE stats set statsviews = statsviews + 1 WHERE statsId = 3;';
              }
       
              $updt = mysqli_query ($db, $update);

              if($_SESSION["role"] == "admin")
              {
                     echo '<form method="post">
                     <div>
                     <input type="submit" class="preedit" value="Редагувати" name="edit" />
                     </div>
                     </form>';
              }
              echo '<form action="add.php" method="post">';
              echo '<div class="card">';
              echo '<div class="imag">';
              echo '<img class="neimage" src="images/'.$myr["image"].'">';
              echo'</div>';

              echo '<div class="textcont">';
              echo '<h4 class="goodname">'.$myr['goodsname'].'</h4>';
              echo '<div class="numbers"><h4>Ціна:</h4><h4 class="goodcost">'.$myr['goodscost'].'</h4></div>';
              echo '<div class="numbers"><h4>Категорія товару:</h4><h4 class="categoryname">'.$myr['categoryname'].'</h4></div>';
              echo '<h4 style="margin-bottom: 20px;">Опис товару</h4><h4 class="goodsdescription" style="color: white;">'.$myr['goodsdescription'].'</h4>';
              echo '</div>';
              echo '<div class="indecrease">';
              echo '<button type="button" class="aamount" onclick="increase()">+</button>';
              echo '<input type="text" class="amount" id="amount" name="amount" value="1">';
              echo '<button type="button" class="bamount" onclick="decrease()">-</button>';
              echo'</div>';
              echo '<div>';
              echo '<input type="submit" class="addtocrd" value="Додати до кошика" name="ddtocrd">';
              echo '</div>';
              echo '</div>';
              echo '</form>';
       }
       echo '<h4 style="text-align: center; margin-bottom: 20px;">Коментарі</h4>';
       echo '<div class="commentcreation">';

       echo '<form method="post">
       <input type="text" class="commentfield" name="commen" maxlength="70" />
       <input type="submit" class="commentsubmit name="sub" />
       </form>';

       echo '</div>';

       echo '<div class="commentsection">';

       $ggg= 'SELECT commentContent, commentTime, us.username FROM `comments` as cm 
       RIGHT JOIN user as us ON us.userId = cm.userId
       where cm.goodsId = '.$_GET['i_id'].' order by commentTime';
       $result = mysqli_query ($db, $ggg);

       while($myr = mysqli_fetch_array($result))
       {
              echo '<div class="comment">';
              echo '<div class="commentuser">';
              echo '<h4 class="commenttimeo" style="text-align: center;">'.$myr['username'].'</h4>';
              echo '</div>';
              echo '<div class="commentcontent">';
              echo '<div class="commenth">';
              echo '<h4 class="hcomm">'.$myr['commentContent'].'</h4>';
              echo '</div>';
              echo '<h4 class="commenttimeo">'.$myr['commentTime'].'</h4>';
              echo '</div>';
              echo '</div>';
       }

       echo '</div>';
       echo '</div>';
}
echo '</div>';

require('footer.php');

?>
<script>
       function increase()
       {
              document.getElementById("amount").value = parseInt(document.getElementById("amount").value) + 1;
       }

       function decrease()
       {
              if(parseInt(document.getElementById("amount").value) >= 2)
              {
                     document.getElementById("amount").value = parseInt(document.getElementById("amount").value) - 1;
              }
       }
</script>