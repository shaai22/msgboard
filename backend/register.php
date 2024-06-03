<?php
// Подключаем класс для работы с БД
require_once('db_boilerplate.php');
$dbClass = new DB();

// Продолжаем сохранённую сессию
session_start();

// Делаем выборку из БД для пользователя с логином из формы
$preRegCheck = $dbClass->select("SELECT * FROM users WHERE login = ?", [$_POST['login']]);

if ($preRegCheck !== []) {
    // Если пользователь зарегистрирован, перенаправляем на страницу входа
    $page_title = 'Регистрация';
    $page_errors = 'Пользователь с таким именем уже зарегистрирован<br><a href="/login.php">Войти</a>';
    include '../templates/page.php';
} else {
    // Если нет, записываем его в БД и сохраняем ID в сессию
    $registeredUID = $dbClass->insert("INSERT INTO users (login, password) VALUES (?, ?)", [$_POST['login'], $_POST['password']]);
    $_SESSION['uid'] = $registeredUID;

    // Если стоит флажок "сохранить данные", запоминаем это в сессии
    if (isset($_POST['remember'])) {
        $_SESSION['remember'] = $_POST['remember'];
    }

    // Перенаправляем на страницу входа
    header('Location: /login.php');
}