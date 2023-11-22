<?php

session_start();
session_unset();
session_destroy();
if (isset($_GET['idvisita'])) {
    header("Location: ../login.php?idvisita=" . $_GET['idvisita']);
} else {
    header("Location: ../login.php");
}
?>
