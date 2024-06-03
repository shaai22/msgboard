<?php
session_start();
if (isset($_SESSION['uid']) && isset($_SESSION['remember'])) {
    header('Location: /messages.php');
} else {
    header('Location: /login.php');
}