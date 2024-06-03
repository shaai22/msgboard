<?php
// Подключаем класс для работы с БД
require_once('db_boilerplate.php');
$dbClass = new DB();

// Продолжаем сохранённую сессию
session_start();

// Делаем выборку из БД по логину и паролю
$userData = $dbClass->select("SELECT id FROM users WHERE login = ? AND password = ?", [$_POST['login'], $_POST['password']]);

if ($userData == []) {
    // Если пользователь не найден, предлагаем снова авторизоваться
    $page_title = 'Вход';
    $page_errors = 'Неверное имя пользователя или пароль<br><a href="/login.php">Повторить</a>';
    include '../templates/page.php';
} else {
    // Если найден, записываем в сессию ID пользователя и флажок "запомнить меня"
    $_SESSION['uid'] = $userData[0]['id'];
    $_SESSION['remember'] = $_POST['remember'];

    // И отправляем на страницу "Сообщения"
    header('Location: /messages.php');
}