<?php
session_start();
if (isset($_SESSION['uid']) && isset($_SESSION['remember'])) {
    header('Location: /messages.php');
} else {
    $page_title = 'Регистрация';
    $page_content = '
<form id="regForm" method="POST" action="backend/register.php">
<div id="errors"></div>
<label for="login">Логин</label>
<input type="text" id="login" name="login" autocomplete="username" onfocus="clearError()"><br>
<label for="password">Пароль</label>
<input type="password" id="password" name="password" autocomplete="new-password" onfocus="clearError()"><br>
<input type="checkbox" name="remember" value="1" checked><label for="remember">Сохранить данные для входа</label><br><br>
<button type="button" onclick="window.location.href=\'/login.php\'"><img class="icon" src="img/icons/back.svg" alt="icon">Назад</button>
<button type="button" onclick="validateReg()"><img class="icon" src="img/icons/register.svg" alt="icon">Зарегистрироваться</button>
</form>
<script>
regForm = document.querySelector("#regForm");
errors = document.querySelector("#errors");
login = document.querySelector("#login");
password = document.querySelector("#password");
function clearError() {
    errors.innerText = "";
    login.style.border = "none";
    password.style.border = "none";
}
function validateReg() {
    allowedChars = new RegExp("^[a-zA-Z0-9_-]+$");
    minPasswordLen = new RegExp("^.{6}$");

    if(login.value !== "") {
        if(allowedChars.test(login.value)) {
            if(minPasswordLen.test(password.value)) {
                regForm.submit();
            } else {
                errors.innerText = \'Минимальная длина пароля - 6 символов\';
                password.style.border = \'2px solid red\';
            }
        } else {
            errors.innerText = \'Логин может содержать только латинские буквы, цифры, подчёркивание и тире\';
            login.style.border = \'2px solid red\';
        }
    } else {
        errors.innerText = \'Заполните логин\';
        login.style.border = \'2px solid red\';
    }
}
</script>
';
}

include 'templates/page.php';