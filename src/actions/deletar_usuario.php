<?php
session_start();
require_once '../config/Database.php';
$connection = Database::getConnection();

$userId = $_GET['id'];
if (!empty($userId)) {
    $deleteStatement = $connection->prepare("DELETE FROM usuarios WHERE id = ?");
    $deleteStatement->execute([$userId]);
    $_SESSION['mensagemsucesso'] = 'Usuário removido com sucesso!';
}
header ('Location: ../../public/index.php');