<?php
session_start();
unset($_SESSION['loggedID']);
header("Location: index.php");