<?php
session_start();

date_default_timezone_set('America/Fortaleza');

$hora = date('H');

$nomeUsuario = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Visitante';

$nomeUsuario = htmlspecialchars($nomeUsuario, ENT_QUOTES, 'UTF-8');

$mensagem = '';

if ($hora >= 1 && $hora < 12) {
    $mensagem = "<p>Bom dia, $nomeUsuario!</p>";
} elseif ($hora >= 12 && $hora < 18) {
    $mensagem = "<p>Boa tarde, $nomeUsuario!</p>";
} elseif ($hora >= 18 && $hora < 24) {
    $mensagem = "<p>Boa noite, $nomeUsuario!</p>";
} else {
    $mensagem = "<p>Boa madrugada, $nomeUsuario!</p>";
}

if ($nomeUsuario !== 'Visitante') {
    $logout = '<a href="./processar/logout.php"><p>Logout</p></a>';
    $fazer_login = '';
} else {
    $logout = '';
    $fazer_login = '<a href="./login.php"><p>Fazer login</p></a>';
}


if (isset($_SESSION['admin']) && $_SESSION['admin'] != 0) {
    if (basename($_SERVER['PHP_SELF']) !== "admin.php") {
        $linkAdmin = '<a href="./admin.php">Menu Admin</a>';
    } else {
        $linkAdmin = '';
    }
} else {
    $linkAdmin = '';
}

if (basename($_SERVER['PHP_SELF']) !== "index.php") {
    $linkHome = '<a href="index.php">Home</a>';
} else {
    $linkHome = '';
}

if (basename($_SERVER['PHP_SELF']) !== "sobre.php") {
    $linkSobre = '<a href="sobre.php">Sobre</a>';
} else {
    $linkSobre = '';
}


?>