<?php
session_start();
require_once '../config/Database.php';
$connection = Database::getConnection();

$userId = $_GET['id'];
if (!empty($userId)) {
    $userData = [];
    $selectStatement = $connection->prepare("SELECT nome, email FROM usuarios WHERE id = ?");
    $selectStatement->execute([$userId]);

    $userData = $selectStatement->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: ..' . '/..' . '/public/index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        html,
        body {
            height: 100%;
        }

        input {
            padding: 12px;
            margin-bottom: 10px;
            width: 100%;
            font-size: 18px;
        }

        form {
            border: 3px solid #000;
            padding: 20px;
            width: 600px;
        }

        .conteiner {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100%;
            padding-top: 50px;
        }

        .header {
            text-align: center;
            margin-bottom: 20 px;
        }

        label {
            display: block;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="conteiner">
        <form action="../actions/editar_usuario_action.php" method="post">
            <h2 class="header">EDITAR USUÁRIO</h2>
            <input type="hidden" name="id" value="<?= $userId ?>">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required value="<?= $userData['nome'] ?>">
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required value="<?= $userData['email'] ?>">
            <br>
            <input type="submit" value="Salvar">
        </form>
        <?php if (!empty($_SESSION['mensagemerro'])) : ?>
            <p style="color:red">[ERRO]: <?= $_SESSION['mensagemerro'] ?></p>
        <?php endif; ?>
    </div>
</body>

</html>