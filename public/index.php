    <?php
    session_start();
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once '../src/config/Database.php';
    
    use Dotenv\Dotenv;
    
    $dotEnv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotEnv->safeLoad();
    
    if(!isset($_SESSION['db_config'])) {
        $_SESSION['db_config'] = [
            'host' => $_ENV['DB_HOST'] ?? null,
            'port' => $_ENV['DB_PORT'] ?? null,
            'dbname' => $_ENV['DB_NAME'] ?? null,
            'dbuser' => $_ENV['DB_USER'] ?? null,
            'dbpass' => $_ENV['DB_PASS'] ?? null
            
        ];
    }
    
    $connection = Database::getConnection();
    
    $dbData = [];
    $selectStatement = $connection->query("SELECT * FROM usuarios");
    $selectStatement->execute();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuários</title>
        <style>
            * {
                font-family:Arial, Helvetica, sans-serif;
            }

            table tbody {
                text-align:center;
            }

            tr,
            td,
            th,
            table {
                border:1px solid #000;
            }

            th,
            td {
                padding:10px;
            }

            td {
                font-size:20px;
            }

            tbody tr:hover {
                background-color:#DDD9CE;
            }

            a {
                text-decoration: none;
            }
            
            a:visited,
            a:link {
                color:#000;
            }

            a:hover {
                text-decoration:underline;
            }

        </style>
    </head>

    <body>
        
        <h2>LISTA DE USUÁRIOS <a class="botao" href="../src/views/adicionar_usuario.php" class="botao-adicionar">[ADICIONAR NOVO]</a></h2>
        <table width=100%>
            <thead>
                <th>ID</th>
                <th>NOME</th>
                <th>EMAIL</th>
                <th>AÇÕES</th>
            </thead>

            <tbody>
                <?php while($dbData = $selectStatement->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?= $dbData['id'] ?></td>
                        <td><?= $dbData['nome'] ?></td>
                        <td><?= $dbData['email'] ?></td>
                        <td>
                            <a class="botao" href="../src/views/editar_usuario.php?id=<?=$dbData['id'] ?>">[EDITAR]</a>
                            <a class="botao" href="../src/actions/deletar_usuario.php?id=<?= $dbData['id'] ?>" onclick="return confirm('Confirma a exclusão do usuário?')">[EXCLUIR]</a>
                        </td>
                    </tr>
                <?php endwhile ?>
                <tr></tr>
            </tbody>
        </table>
        <?php if(!empty($_SESSION['mensagemsucesso'])) : ?>
            <p style="color:green"><?= $_SESSION['mensagemsucesso'] ?></p>
            <?php unset($_SESSION['mensagemsucesso']) ?>
        <?php endif; ?>
        <?php if(!empty($_SESSION['mensagemerro'])) : ?>
            <p style="color:red">[ERRO]: <?= $_SESSION['mensagemerro'] ?></p>
            <?php unset($_SESSION['mensagemerro']) ?>
        <?php endif; ?>
    </body>

    </html>