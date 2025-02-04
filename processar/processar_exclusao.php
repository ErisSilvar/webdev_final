<?php
// Inicia a sessão e importa as classes necessárias
session_start();

require_once '../class/rb.php';
include_once '../inc/conexaobd.inc.php';

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    $_SESSION['mensagem'] = ['texto' => 'Você não tem permissão para realizar essa ação.', 'tipo' => 'erro'];
    header('Location: ../listarusuarios.php');
    exit();
}

// Verifica se o ID de exclusão foi enviado
if (isset($_POST['excluir_id'])) {
    $excluir_id = $_POST['excluir_id'];

    // Não permite a exclusão do root (id = 1)
    if ($excluir_id != 1) {
        // Carregar o usuário a ser excluído
        $usuario = R::load('usuario', $excluir_id);

        // Verifica se o usuário existe
        if ($usuario->id) {
            // Exclui o usuário
            R::trash($usuario);
            $_SESSION['mensagem'] = ['texto' => 'Usuário excluído com sucesso!', 'tipo' => 'sucesso'];
        } else {
            $_SESSION['mensagem'] = ['texto' => 'Usuário não encontrado!', 'tipo' => 'erro'];
        }
    } else {
        $_SESSION['mensagem'] = ['texto' => 'Você não pode excluir o usuário root.', 'tipo' => 'erro'];
    }
} else {
    $_SESSION['mensagem'] = ['texto' => 'ID de exclusão não fornecido.', 'tipo' => 'erro'];
}

header('Location: ../deletaruser.php');
exit();
