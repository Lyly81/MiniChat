<?php
    declare(strict_types=1);

    const DSN = "mysql:dbname=mini_chat;host=localhost;port=3308;charset=utf8mb4";
    const ID = 'root';
    const PWD = '';
    const OPTIONS = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    try {
	    $db = new PDO(DSN, ID, PWD, OPTIONS);
    } catch (PDOException $e) {
	    exit("Erreur : {$e->getMessage()}");
    }