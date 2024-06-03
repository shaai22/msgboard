<?php
session_start();
if (isset($_SESSION['uid']) && isset($_SESSION['remember'])) {
    header('Location: /messages.php');
} else {
    $page_title = 'Вход';
    $page_content = '
<form method="POST" action="backend/login.php">
    <label for="login">Логин</label>
    <input type="text" name="login" autocomplete="username" required><br>
    <label for="password">Пароль</label>
    <input type="password" name="password" autocomplete="current-password" required><br>
    <input type="checkbox" name="remember" value="1" checked><label for="remember">Запомнить меня</label><br><br>
    <button type="submit"><img class="icon" src="img/icons/login.svg" alt="icon">Войти</button><button type="button" onclick="window.location.href=\'/register.php\'"><img class="icon" src="img/icons/register.svg" alt="icon">Зарегистрироваться</button>
</form>
</div>
</div>
';
}

include 'templates/page.php';