<?php
// Подключаем класс для работы с БД
require_once('db_boilerplate.php');
$dbClass = new DB();

// Продолжаем сохранённую сессию
session_start();

// Проверяем наличие авторизации
if (isset($_SESSION['uid'])) {
    $dbClass->query('DELETE FROM messages WHERE id = ?', [$_GET['id']]);   
} else {
    echo 'Чтобы удалять сообщения, нужно <a href="/login.php">авторизоваться</a>';
    die();
}

// Перенаправляем на страницу с сообщениями
header('Location: /messages.php');