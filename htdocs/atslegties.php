<?php
session_start();
session_destroy();
unset($_SESSION['Lietotajvards']);
header("location: index.php");
?>