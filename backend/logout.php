<?php
// Продолжаем сохранённую сессию
session_start();

// Обнуляем содержимое сессии и закрываем её
$_SESSION = [];
session_destroy();

// Перенаправляем на страницу входа
header('Location: /login.php');