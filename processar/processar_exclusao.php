<?php
session_start();

require_once '../class/rb.php';
include_once '../inc/conexaobd.inc.php';


if (isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
    header('location: ../index.php');
    exit();
}

if (isset($_POST['excluir_id'])) {
    $excluir_id = $_POST['excluir_id'];

    if ($excluir_id != 1) {
        $usuario = R::load('usuario', $excluir_id);

        if ($usuario->id) {
            R::trash($usuario);
            $_SESSION['mensagem'] = ['texto' => 'Usuário excluído com sucesso!', 'tipo' => 'sucesso'];
        }
    }
} else {
    $_SESSION['mensagem'] = ['texto' => 'ID de exclusão não fornecido.', 'tipo' => 'erro'];
}

header('Location: ../gerenciaruser.php');
exit();
