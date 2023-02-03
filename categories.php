<header>
<link rel="stylesheet" href="categories.css">
</header>

<?php
function nav_bar()
{
echo '<div>
<img src="images/header.png" style="width: 100%;" />
</div>';
    echo '<nav>
            <ul class="topmenu">';
              echo '<li><a href="index.php">Головна</a></li>
              <li><a href="" class="down">Категорії</a>
                <ul class="submenu">
                  <li><a href="index.php?category=1">Сіялки</a></li>
                  <li><a href="index.php?category=2">Топори, пили</a></li>
                  <li><a href="index.php?category=3">Оприскувачі</a></li>
                </ul>
              </li>';
              if($_SESSION["auth"] == "true")
              {
                echo '<li><a href="order.php" class="down">Корзина</a></li>';
              }
              echo'<li id="searchbox">
                <form action="index.php?search=1" method="post">
                  <input type="text" class="searchby" name="searchby">
                  <input type="submit" class="searchbtn" value="Пошук">
                  <button type="button" id="filter" class="filter" onclick="pressed()">Фільтр</button>
                  <input type="text" id="fcost" class="fcost" name="fcost">
                </form>
              </li>';
              if($_SESSION['role'] == "admin")
              {
                echo '<li><a style="color: orange;" href="" class="down">Адмін</a>';
                echo '<ul class="submenu">';
                echo '<li><a style="color: orange;" href="statistics.php">Статистика</a></li>';
                echo '<li><a style="color: orange;" href="insert.php">Додати товар</a></li>';
                echo '</ul>';
                echo '</li>';
              }
              if($_SESSION["auth"] == "true")
              {
                echo '<li id="exitance"><a href="logout.php">Вийти</a></li>';
              }else
              {
                echo '<li id="exitance"><a href="auth.php">Авторизація</a></li>';
              }
              echo '</ul>
          </nav>';
}
nav_bar();
?>

<script>
  document.getElementById("fcost").style.visibility = "hidden";

  function pressed()
  {
    if(document.getElementById("fcost").style.visibility == "hidden")
    {
      document.getElementById("fcost").style.visibility = "visible";
      document.getElementById("filter").innerText = "Ціна до";
      document.getElementsByClassName("filter")[0].style.background = "orange";
      return;
    }else{
      document.getElementById("fcost").style.visibility = "hidden";
      document.getElementById("filter").innerText = "Фільтр";
      document.getElementsByClassName("filter")[0].style.background = "darkseagreen";
      return;
    }
  }
</script>