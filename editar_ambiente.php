<?php
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
    header('location: index.php');
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Ambiente não encontrado.'];
    header('location: gerenciarambiente.php');
    exit();
}

$id_ambiente = $_GET['id'];

$ambiente = R::load('ambiente', $id_ambiente);

if (!$ambiente->id) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Ambiente não encontrado.'];
    header('location: gerenciarambiente.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ambiente</title>
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

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 460px;
            width: 90%;
        }

        .container h2 {
            color: #0c3468;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            color: #1f788c;
        }

        .form-group input {
            width: 95%;
        }

        .form-group select {
            width: 100%;
        }

        .form-group input,
        .form-group select {
            padding: 10px;
            border: 1px solid #1f788c;
            border-radius: 5px;
            font-size: 1rem;
        }


        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #1f788c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #1f788c;
        }
    </style>
</head>

<body>
    <header>
        <?php include_once('./inc/cabecalho.inc.php'); ?>
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
            <h2>Editar Ambiente</h2>
            <form action="./processar/processar_editarambiente.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $ambiente->id; ?>">

                <div class="form-group">
                    <label for="tipo">Tipo de Ambiente:</label>
                    <select id="tipo" name="tipo" required>
                        <option value="sala" <?php echo ($ambiente->tipo == 'sala') ? 'selected' : ''; ?>>Sala</option>
                        <option value="laboratorio" <?php echo ($ambiente->tipo == 'laboratorio') ? 'selected' : ''; ?>>
                            Laboratório</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($ambiente->nome); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <input type="text" id="descricao" name="descricao"
                        value="<?php echo htmlspecialchars($ambiente->descricao); ?>" required>
                </div>

                <div class="form-group">
                    <label for="arquivo">Nova Imagem (Apenas formatos JPG, JPEG, PNG, e GIF):</label>
                    <input type="file" id="arquivo" name="arquivo">
                </div>

                <button type="submit" class="btn-submit">Salvar Alterações</button>
            </form>
        </div>
    </main>
    <footer>
        <?php include_once('./inc/rodape.inc.php'); ?>
    </footer>
</body>

</html>