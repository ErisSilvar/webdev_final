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
    <title>Cadastrar ambiente</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/notificacao.css">
  
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: auto;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            text-align: center;
        }

        .container h2 {
            color: #2e7d32;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            color: #2e7d32;
        }

        .form-group input,
        .form-group select {
            width: 95%;
            padding: 10px;
            border: 1px solid #66bb6a;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #66bb6a;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
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
    </style>

</head>

<body>
    <header>
        <?php
        include_once('./inc/cabecalho.inc.php');
        ?>
    </header>
    <main>
        <?php
        if (isset($_SESSION['mensagem'])) {
            $mensagem = $_SESSION['mensagem'];
            echo "<div class='notificacao {$mensagem['tipo']}'>{$mensagem['texto']}</div>";
            unset($_SESSION['mensagem']);
        }
        ?>
        <div class="container">
            <h2>Cadastro de Ambiente</h2>
            <form action="./processar/processarambiente.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="tipo">Tipo de Ambiente:</label>
                    <select id="tipo" name="tipo" required>
                        <option value="" >Selecione</option>
                        <option value="sala" >Sala</option>
                        <option value="laboratorio" >Laboratório</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <input type="text" id="descricao" name="descricao" required>
                </div>
                <div class="form-group">
                    <label for="arquivo">Imagem do ambiente: [Apenas formatos JPG, JPEG, PNG e GIF]</label>
                    <input type="file" id="arquivo" name="arquivo">

                </div>
                <button type="submit" class="btn-submit">Cadastrar</button>
            </form>
        </div>

    </main>
    <footer>
        <?php include_once('./inc/rodape.inc.php') ?>
    </footer>

</body>

</html>