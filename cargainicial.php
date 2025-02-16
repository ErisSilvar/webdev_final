<?php
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';

$erroBanco = false;
if (!R::testConnection()) {
    $erroBanco = true;
}

try {

    $tabelaExiste = R::getCell('SHOW TABLES LIKE "usuario"') != null;
} catch (Exception $e) {
    $tabelaExiste = false;
}

$temAdmin = false;
if ($tabelaExiste) {

    $temAdmin = R::count('usuario', 'admin = 1') > 0;
}

if (!$tabelaExiste || !$temAdmin) {


    if (!$temAdmin) {
        $nome = 'root';
        $email = 'root@admin.com';
        $senha = password_hash('asdf', PASSWORD_DEFAULT);
        $admin = 1;

        $user = R::dispense('usuario');
        $user->nome = $nome;
        $user->email = $email;
        $user->senha = $senha;
        $user->admin = $admin;
        R::store($user);
    }
    header('Location: ./index.php');
    exit;
}
?>