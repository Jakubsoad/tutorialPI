<?php
session_start();

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Admin Panel</title>
</head>
<body>
<h1>Newsletter</h1>

<form method="post" action="save.php">
    <input type="text" name="email" placeholder="E-mail..."
        <?php if (isset($_SESSION['givenEmail'])) echo 'value="'.$_SESSION['givenEmail'].'"'?>>
    <br><br>

    <?php
    if (isset($_SESSION['wrongEmail']))
        echo $_SESSION['wrongEmail'];
    unset($_SESSION['wrongEmail']);
    ?>
    <br><br>
    <input type="submit" value="Submit!">


</form>

</body>

</html>