<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Newsletter</title>
</head>
<body>
<h1>Newsletter</h1>
<form method="post" action="save.php">
    <input type="text" name="email" placeholder="E-mail..."
        <?php if (isset($_SESSION['givenEmail'])) echo 'value="'.$_SESSION['givenEmail'].'"'?>>
    <br><br>

    <?php
    if (isset($_SESSION['wrongEmail'])) {
        echo $_SESSION['wrongEmail'];
        unset($_SESSION['wrongEmail']);
    }
    if (isset($_SESSION['emailExist']))
    {
        echo $_SESSION['emailExist'];
        unset($_SESSION['emailExist']);
    }



    ?>
    <br><br>
    <input type="submit" value="Submit!">
    </form>
<br><br>
    <form method="post" action="delete.php">
        <input type="text" name="email" placeholder="Email to erase...">
        <br>
    <input type="submit" value="Delete my address e-mail from database!" >
    </form>
<?php
if (isset($_SESSION['cancelledEmail']))
{
    echo $_SESSION['cancelledEmail'];
    unset($_SESSION['cancelledEmail']);
}
?>
    <a href="admin.php">You are admin? Click here!</a>


</body>

</html>