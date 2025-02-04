<?php
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
    header('location: index.php');
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/notificacao.css">
    <style>
        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100vh;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgba(92, 122, 100, 0.61);
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 40%;
            max-width: 400px;
            text-align: center;
        }

        .container h2 {
            color: #2e7d32;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            color: #2e7d32;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #66bb6a;
            border-radius: 5px;
            font-size: 1rem;
        }

        .check-admin {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
        }

        .check-admin label {
            font-weight: normal;
            color: #2e7d32;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #2e7d32;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #1b5e20;
        }

        @media (max-width: 600px) {
            .container {
                width: 90%;
            }
        }
    </style>

    </style>
</head>

<body>
    <header>
        <?php
        include_once('./inc/cabecalho.inc.php');
        ?>
    </header>
    <?php
    if (isset($_SESSION['mensagem'])) {
        $mensagem = $_SESSION['mensagem'];
        echo "<div class='notificacao {$mensagem['tipo']}'>{$mensagem['texto']}</div>";
        unset($_SESSION['mensagem']);
    }
    ?>
    <div class="container">
        <h2>Cadastro de Usuário</h2>
        <form action="./processar/processaruser.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <div class="check-admin">
                    <input type="checkbox" id="admin" name="admin" value="1">
                    <label for="admin">Administrador</label>
                </div>
            </div>
            <button type="submit" class="btn-submit">Cadastrar</button>
        </form>
    </div>
    <footer>
        <?php
        include_once('./inc/rodape.inc.php');
        ?>
    </footer>
</body>

</html>