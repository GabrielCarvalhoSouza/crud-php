<?php

class Database {
    public static function connect() {
        $host = getenv('POSTGRES_HOST');
        $db   = getenv('POSTGRES_DB');
        $user = getenv('POSTGRES_USER');
        $pass = getenv('POSTGRES_PASSWORD');
        $port = getenv('POSTGRES_PORT');
        
        $dsn = "pgsql:host=$host;port=$port;dbname=$db";
        
        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            return $pdo;
        } catch (PDOException $e){
            die("Erro de conexão:; " . $e->getMessage());
        }
    }
}