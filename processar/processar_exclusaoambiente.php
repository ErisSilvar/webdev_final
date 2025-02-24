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

    $ambiente = R::load('ambiente', $excluir_id);

    if ($ambiente->id) {
        $imagePath = './uploads/ambientes/' . $ambiente->imagem;

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        R::trash($ambiente);

        $_SESSION['mensagem'] = ['texto' => 'Ambiente excluído com sucesso!', 'tipo' => 'sucesso'];
    }
} else {
    $_SESSION['mensagem'] = ['texto' => 'ID de exclusão não fornecido.', 'tipo' => 'erro'];
}

header('Location: ../gerenciarambiente.php');
exit();
