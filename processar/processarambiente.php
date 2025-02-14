<?php
session_start();

if (isset($_POST['tipo']) && isset($_POST['nome']) && isset($_POST['descricao']) && isset($_FILES['arquivo'])) {
    $tipo = $_POST['tipo'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $arquivo = $_FILES['arquivo'];

    require_once '../class/rb.php';
    include_once '../inc/conexaobd.inc.php';

    try {
        $ambienteExistente = R::findOne('ambiente', 'nome = ?', [$nome]);
        if ($ambienteExistente) {
            $_SESSION['mensagem'] = ['texto' => 'Este ambiente já está cadastrado no sistema.', 'tipo' => 'erro'];
            header('Location: ../cadastrarambiente.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['mensagem'] = ['texto' => 'Erro ao verificar ambiente: ' . $e->getMessage(), 'tipo' => 'erro'];
        header('Location: ../cadastrarambiente.php');
        exit();
    }




    try {
        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Erro no upload do arquivo.');
        }
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

        if (!in_array($extensao, $extensoesPermitidas)) {
            throw new Exception('Formato de arquivo inválido. Apenas imagens (JPG, JPEG, PNG, GIF) são permitidas.');
        }

        $uniqueName = uniqid('ambiente_', true) . '.' . $extensao;

        $uploadDir = 'uploads/ambientes/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadFilePath = $uploadDir . $uniqueName;

        if (!move_uploaded_file($arquivo['tmp_name'], $uploadFilePath)) {
            throw new Exception('Erro ao mover o arquivo para o diretório.');
        }

        $ambiente = R::dispense('ambiente');
        $ambiente->tipo = $tipo;
        $ambiente->nome = $nome;
        $ambiente->descricao = $descricao;
        $ambiente->imagem = $uniqueName;

        $id = R::store($ambiente);
        R::close();

        $_SESSION['mensagem'] = ['texto' => 'Ambiente cadastrado com sucesso!', 'tipo' => 'sucesso'];
    } catch (Exception $e) {
        $_SESSION['mensagem'] = ['texto' => $e->getMessage(), 'tipo' => 'erro'];
    }
} else {
    $_SESSION['mensagem'] = ['texto' => 'Preencha todos os campos.', 'tipo' => 'erro'];
}

header('Location: ../cadastrarambiente.php');
exit();
