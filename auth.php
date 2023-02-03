<html>
<head>
<title>Авторизація</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<style>
    body { background: darkseagreen; }
</style>

<?php
session_start();

if(!isset($_SESSION['logged_user']))
{
echo '<form class="auth" method="post">';
echo '<div class="ac">';
echo '<div class="double"><h4 class="authh4">Логін:</h4>';
echo '<h4 class="authh4">Пароль:</h4></div>';
echo '<div class="ins"><input class="inputy" type="text" name="user_name"><input class="inputy" type="password" name="user_pass"></div>';
echo '</div>';
echo '<input type="submit" class="sinp" name="Submit" value="Увійти">';
echo '<a class="asignupbtn" href="signup.php">Реєстрація</a>';


if($_POST)
{
    $USERNAME = $_POST["user_name"];
    $PASSWORD = $_POST["user_pass"];

    $db = mysqli_connect("localhost", "root", "", "wodz");
    $ggg= 'SELECT * FROM `user` WHERE username = "'.$USERNAME.'";';
    $result = mysqli_query ($db, $ggg);
    $myr = mysqli_fetch_array($result);

    if($myr["username"] == null || $myr["username"] == "")
    {
        echo "<h4 id='err2'>Користувача не знайдено</h4>";
    }


    else if($myr["username"] == $USERNAME && password_verify($PASSWORD, $myr["userpassword"]) == 1)
    {
        session_start();
        $_SESSION['auth'] = "true";
        $_SESSION['logged_user'] = $USERNAME;
        $_SESSION['logged_userid'] = $myr['userId'];
        $_SESSION['role'] = $myr["userrole"];

    if($myr["userrole"] == "admin")
    {
        header("Location: index.php");
    }else
    {
        header("Location: index.php");
    }
    }else
    {
        echo "<h4 id='err2'>Не вірний логін або пароль</h4>";
    }
}
echo '</form>';
}else
{

    echo '<form action="logout.php" class="auth" method="post">';
    echo '<div class="double"><h4 class="user">Вітаємо, '.$_SESSION['logged_user'].'!</h4></div>';
    echo '<input type="submit" class="sinp" name="Submit" value="Вийти">';
    echo '</form>';
}

?>

</body>
</html>