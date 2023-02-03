<html>
<head>
<title>Реєстрація</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<style>
    body { background: darkseagreen; }

    h4 {
        font-size: 18px;
        margin: 0px;
    }

    input {
        margin: 0;
    }
</style>

<?php
session_start();

echo '<form  class="signcard" method="post">';
echo '<div class="ac">';
echo '<div class="signoble"><h4 style="margin-bottom: 20px;">Логін:</h4><h4 style="margin-bottom: 20px;">Пароль:</h4><h4 style="margin-bottom: 20px;">Підтвердити пароль:</h4></div>';
echo '<div class="signins"><input class="signinput" type="text" name="user_name"><input class="signinput" type="password" id="ps1" name="user_pass"><input class="signinput" id="ps2" type="password" name="user_rpass"></div></div>';
echo '<input type="button" class="ssinp" onclick="clck()" value="Зареєструватися">';
echo '<a class="asignupbtn" href="auth.php">Авторизація</a>';
echo '<input type="submit" id="sub" style="visibility: hidden;" name="Submit" value="Зареєструватися">';
echo '<h4 id="err1" style="visibility: hidden;">Паролі не співпадають</h4>';

if($_POST)
{
    session_start();
    $USERNAME = $_POST["user_name"];
    $PASSWORD = $_POST["user_pass"];
    
    $db = mysqli_connect("localhost", "root", "", "wodz");
    $ggg= 'SELECT * FROM `user` WHERE username = "'.$USERNAME.'";';
    $result = mysqli_query ($db, $ggg);
    
    $myr = mysqli_fetch_array($result);
    
    
    if($myr["username"] == $USERNAME)
    {
        echo "<h4 id='errs'>Користувач вже існує</h4>";
    }else
    {
        $PASS = password_hash($PASSWORD, PASSWORD_DEFAULT);
        $ggg= 'INSERT INTO `user` (username, userpassword, userrole) VALUES("'.$USERNAME = $_POST["user_name"].'", "'.$PASS.'", "customer")';
        $result = mysqli_query ($db, $ggg);
        header("Location: auth.php");
    }
}
echo '</form>';

?>

<script>
    function clck()
    {
        if(document.getElementById("ps1").value == document.getElementById("ps2").value)
        {
            document.getElementById("sub").click();
        }else{
            document.getElementById("err1").style.visibility = "visible";
        }
    }
</script>

</body>
</html>