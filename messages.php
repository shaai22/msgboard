<?php
require_once('backend/db_boilerplate.php');
session_start();
$dbClass = new DB();
$page_title = 'Объявления';
if (isset($_SESSION['uid'])) {
    $page_content = '
<details>
<summary>Написать новое</summary>
<div>
    <br>
    <textarea id="messageText" name="message" rows="5" cols="28" maxlength="140" required></textarea><br><br>
    <button type="button" onclick="sendMsg()"><img class="icon" src="img/icons/send.svg" alt="icon">Отправить</button>
</div>
</details>
<br>
<div id="message-list">
</div>
<script>
var messageList = document.querySelector("#message-list");

async function getMessages() {
    messageList.innerHTML = "";
    await fetch("/backend/get_messages.php")
    .then((response) => response.json())
    .then((data) => {
        for (const message of data) {
            messageList.innerHTML += `<div class=\"message\">
                <table>
                    <tr>
                        <td>
                            <p class=\"message-login\">${message.login}</p>
                            <p class=\"message-content\">${message.content}</p>
                        </td>
                    </tr>
                </table>
            </div>`;
        }
    });
}

async function sendMsg() {
    var formData = new URLSearchParams();
    formData.set("message", document.querySelector("#messageText").value);
    await fetch("/backend/send.php", {
        method: "POST",
        body: formData,
        credentials: "include"
    });
    getMessages();
}

window.onload = function() { getMessages(); }
</script>
';
$page_content .= '
</table>
<br>
<form method="POST" action="backend/logout.php">
    <button type="submit"><img class="icon" src="img/icons/logout.svg" alt="icon">Выйти</button>
</form>
</div>
</div>
</body>
</html>
';
} else {
    $page_content = '<div id="errors">Вы должны <a href="/login.php">авторизоваться</a>, чтобы просматривать эту страницу</div>';
}

include 'templates/page.php';