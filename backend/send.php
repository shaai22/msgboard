<?php
require_once('db_boilerplate.php');
$dbClass = new DB();

session_start();

if ($dbClass->insert("INSERT INTO messages (owner, content) VALUES (?, ?)", [$_SESSION['uid'], $_POST['message']])) {
    echo 'ok';
} else {
    echo 'error';
}