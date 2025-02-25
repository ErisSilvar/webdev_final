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
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $admin = isset($_POST['admin']) ? 1 : 0;

    $usuario = R::load('usuario', $id);

    if (!$usuario->id) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Usuário não encontrado.'];
        header('location: ../gerenciaruser.php');
        exit();
    }
    $usuario->nome = $nome;
    $usuario->email = $email;
    if (!empty($senha)) {
        $usuario->senha = password_hash($senha, PASSWORD_DEFAULT);
    }
    $usuario->admin = $admin;

    R::store($usuario);

    $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Usuário atualizado com sucesso.'];
    header('location: ../gerenciaruser.php');
    exit();
} else {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Requisição inválida.'];
    header('location: ../gerenciaruser.php');
    exit();
}
