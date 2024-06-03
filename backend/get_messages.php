<?php
require_once('db_boilerplate.php');
$dbClass = new DB();

$messages = $dbClass->select("SELECT messages.id, messages.owner, messages.content, users.login FROM messages LEFT JOIN users ON messages.owner = users.id");

echo json_encode($messages);