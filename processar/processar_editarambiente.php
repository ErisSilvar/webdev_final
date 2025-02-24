<?php
require_once '../class/rb.php';
require_once '../inc/conexaobd.inc.php';
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Acesso negado.'];
    header('location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);

    $ambiente = R::load('ambiente', $id);

    if (!$ambiente->id) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Ambiente não encontrado.'];
        header('location: ../gerenciarambientes.php');
        exit();
    }

    $ambiente->tipo = $tipo;
    $ambiente->nome = $nome;
    $ambiente->descricao = $descricao;

    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        if ($ambiente->imagem) {
            $imagemAntiga = '../processar/uploads/ambientes/' . $ambiente->imagem;
            if (file_exists($imagemAntiga)) {
                unlink($imagemAntiga);
            }
        }

        $extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
        $novo_nome = uniqid('ambiente_', true) . '.' . $extensao;
        $uploadDir = '../processar/uploads/ambientes/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadDir . $novo_nome);

        $ambiente->imagem = $novo_nome;
    }

    R::store($ambiente);

    $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Ambiente atualizado com sucesso.'];
    header('location: ../gerenciarambiente.php');
    exit();
} else {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Requisição inválida.'];
    header('location: ../gerenciarambiente.php');
    exit();
}
