<?php
require_once('backend/db_boilerplate.php');
session_start();
$dbClass = new DB();
$page_title = 'Объявления';
if (isset($_SESSION['uid'])) {
    $page_content = '
<details>
<summary>Написать новое</summary>
<form method="POST" action="backend/send.php">
    <br>
    <textarea name="message" rows="5" cols="28" maxlength="140" required></textarea><br><br>
    <button type="submit"><img class="icon" src="img/icons/send.svg" alt="icon">Отправить</button>
</form>
</details>
<br>
';
$messages = $dbClass->select("SELECT messages.id, messages.owner, messages.content, users.login FROM messages LEFT JOIN users ON messages.owner = users.id");

if ($messages == []) {
    $page_content .= '<div class="message"><p style="text-align:center">Нет объявлений</p></div>';
} else {
    $page_content .= '';
    foreach ($messages as $message) {
        if($message['owner'] == $_SESSION['uid']) {
            $page_content .= '<div class="message">
            <table>
                <tr>
                    <td>
                        <p class="message-login">' . $message['login'] . '</p>
                        <p class="message-content">' . $message['content'] . '</p>
                    </td>
                    <td>
                        <button class="del" type="button" onclick="window.location.href=\'backend/delete.php?id=' .
                        $message['id'] . '\'"><img class="icon" src="img/icons/delete.svg" alt="icon">Удалить</button>
                    </td>
                </tr>
            </table>
            </div>';
        } else {
            $page_content .= '<div class="message">
            <table>
                <tr>
                    <td>
                        <p class="message-login">' . $message['login'] . '</p>
                        <p class="message-content">' . $message['content'] . '</p>
                    </td>
                    <td>
                        <button type="button" disabled><img class="icon" src="img/icons/delete.svg" alt="icon">Удалить</button>
                    </td>
                </tr>
            </table>
            </div>';
        }
    }
}
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