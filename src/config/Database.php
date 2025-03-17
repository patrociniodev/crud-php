<?php

class Database
{
    public static function getConnection(): PDO
    {
        global $_SESSION;

        if (isset($_SESSION['db_config']) && !empty($_SESSION['db_config'])) {
            try {
                $config = $_SESSION['db_config'];
                $connection = new PDO(
                    "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}",
                    $config['dbuser'],
                    $config['dbpass'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
                return $connection;
            } catch (PDOException $e) {
                die('Erro na conexão: ' . $e->getMessage());
            }
        } else {
            die("Erro: Configuração do banco não encontrada na sessão.");
        }
    }
}
