<html>
<head>
<title>LOGOUT</title>
</head>
<body>

<?php

 session_start();

  $_SESSION['logged_user'] = $user_name;
  unset($_SESSION['auth']);
  unset($_SESSION['logged_user']);
  unset($_SESSION['logged_userid']);
  unset($_SESSION['role']);

header("Location: unsigned.php");
?>


</body>
</html>