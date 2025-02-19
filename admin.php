<?php
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 0) {
    header('Location: ./index.php');
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Administrador</title>
    <link rel="stylesheet" href="./style/style.css">
    <style>
        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100vh;
        }

        .menu-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
        }

        h2 {
            color: #0c3468;
            margin-bottom: 20px;
        }

        .menu-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .menu-buttons a {
            display: block;
            background-color:#1796b3;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .menu-buttons a:hover {
            background-color: #1f788c;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <header>
        <?php include_once './inc/cabecalho.inc.php'; ?>
    </header>
    <main>
        <div class="menu-container">
            <h2>Bem-vindo, Administrador!</h2>
            <h3>Escolha uma das opções abaixo para gerenciar o sistema:</h3>
            <div class="menu-buttons">
                <a href="cadastraruser.php">Cadastrar usuários</a>
                <a href="gerenciaruser.php">Gerenciar usuários</a>
                <a href="cadastrarambiente.php">Cadastrar ambientes</a>
                <a href="deletarambiente.php">Deletar ambientes</a>
            </div>
        </div>
    </main>
    <footer>
        <?php include_once './inc/rodape.inc.php'; ?>
    </footer>
</body>

</html>
