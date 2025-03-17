<?php
session_start();
require_once '../config/Database.php';
$connection = Database::getConnection();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'];
    $novoNome = $_POST['nome'];
    $novoEmail = $_POST['email'];
    
    if(!empty($userId)) {
        //Verificando se email é unico 
        $selectStatement = $connection->prepare("SELECT email FROM usuarios WHERE email = ?");
        $selectStatement->execute([$novoEmail]);
        
        if($selectStatement->rowCount() === 0) {
            //Query para editar os dados
            $updateStatement = $connection->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
            $updateStatement->execute([$novoNome, $novoEmail, $userId]);
            $_SESSION['mensagemsucesso'] = 'Informações atualizadas com sucesso!';
            header('Location: ../../public/index.php');
            exit;
        }  else {
            $updateStatement = $connection->prepare("UPDATE usuarios SET nome = ? WHERE id = ?");
            $updateStatement->execute([$novoNome, $userId]);
            $_SESSION['mensagemsucesso'] = 'Informações atualizadas com sucesso!';
            $_SESSION['mensagemerro'] = 'O email informado já está sendo utilizado.';
            header('Location: ../views/editar_usuario.php');
            exit;
        }  
    }
}
else {
    header('Location: ../../public/index.php');
    exit;
}