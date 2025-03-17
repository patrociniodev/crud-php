    <?php
    session_start();
    require_once '../config/Database.php';
    $connection = Database::getConnection();

    $data = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $nome = trim($nome);
        $nome = htmlspecialchars($nome);
        
        $email = $_POST['email'];
        $email = htmlspecialchars($email);

        //Salvando dados na sessão para persistir no formulario
        $_SESSION['formdata'] = $_POST;
        if(!empty($nome) && filter_var($email, FILTER_VALIDATE_EMAIL)) {

            //Verificando se email é unico 
            $selectStatement = $connection->prepare("SELECT email FROM usuarios WHERE email = ?");
            $selectStatement->execute([$email]);
            
            if($selectStatement->rowCount() === 0) {
                $insertStatement = $connection->prepare("INSERT INTO usuarios(nome, email) VALUES(?, ?)");
                $insertStatement->execute([$nome, $email]);
                $_SESSION['mensagemsucesso'] = 'Usuário adicionado com sucesso!';
                unset($_SESSION['formdata']);
                $connection = null;
                header('Location: ../../public/index.php');
                exit;
            } else {
                $_SESSION['mensagemerro'] = 'Não foi possível adicionar, o email já está sendo utilizado por outro usuário.';
                header('Location: ../views/adicionar_usuario.php');
                exit;
            }
        } else {
            $_SESSION['mensagemerro'] = 'Preencha os campos corretamente!';
            header('Location: ../views/adicionar_usuario.php');
            exit;
        }
        header('Location: ../views/adicionar_usuario.php');
        exit;
    }