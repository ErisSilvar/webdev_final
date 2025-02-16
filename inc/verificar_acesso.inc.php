<?php
session_start();


if (isset($_SESSION['email']) && $_SESSION['email'] === "visitante@ifnmg.edu.br") {

    if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
        $_SESSION['msg_visitanteNegado'] = ['texto' => 'Acesso negado. Faça login para continuar.', 'tipo' => 'erro'];
        header("Location: index.php");
        exit();
    }
}
