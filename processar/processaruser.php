<?php
session_start();
if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $admin = isset($_POST['admin']) ? 1 : 0;

    require_once '../class/rb.php';

    include_once '../inc/conexaobd.inc.php';

    try {
        $usuario = R::dispense('usuario');

        $usuario->nome = $nome;
        $usuario->email = $email;
        $usuario->senha = $senha;
        $usuario->admin = $admin;
        date_default_timezone_set('America/Fortaleza');
        $usuario->dataHora = date("Y-m-d H:i:s");


        $id = R::store($usuario);

        R::close();

        $_SESSION['mensagem'] = ['texto' => 'Usuário cadastrado com sucesso!', 'tipo' => 'sucesso'];
    } catch (Exception $e) {
        $_SESSION['mensagem'] = ['texto' => 'Erro ao cadastrar usuário.', 'tipo' => 'erro'];
    }
} else {
    $_SESSION['mensagem'] = ['texto' => 'Preencha todos os campos.', 'tipo' => 'erro'];
}

header('Location: ../cadastraruser.php');
exit();
?>