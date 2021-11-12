<?php

require_once __DIR__ . '/../includes/functions.php';

class Dbh
{
    protected function connectDatabase()
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $host = 'localhost';
            $dbName = $_ENV['LOCAL_DB_NAME'];
            $user = 'root';
            $passWord = '';
        } else {
            $host = $_ENV['SERVER_HOST'];
            $dbName = $_ENV['SERVER_DB_NAME'];
            $user = $_ENV['SERVER_USER_NAME'];
            $passWord = $_ENV['SERVER_PASSWORD'];
        }

        try {
            $dsn = 'mysql:dbname=' . $dbName . ';host=' . $host . ';charset=utf8';
            $pdo = new PDO($dsn, $user, $passWord);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            exit('Database connection error: ' . $e->getMessage());
        }
    }

    protected function getSqlError($sth)
    {
        $error = $sth->errorInfo();
        exit('SQL error: ' . $error[2]);
    }
}
