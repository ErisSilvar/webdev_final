<?php
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
    header('location: index.php');
    exit();
}

$ambientes = R::findAll('ambiente');

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/notificacao.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 80%;
            margin-top: 50px;
            text-align: center;
        }

        .container h2 {
            color: #2e7d32;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #2e7d32;
            color: white;
        }

        .btn-excluir {
            background-color: #e53935;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-excluir:hover {
            background-color: #c62828;
        }
    </style>
</head>

<body>
    <header>
        <?php include_once('./inc/cabecalho.inc.php'); ?>
    </header>

    <?php
    if (isset($_SESSION['mensagem'])) {
        $mensagem = $_SESSION['mensagem'];
        echo "<div class='notificacao {$mensagem['tipo']}'>{$mensagem['texto']}</div>";
        unset($_SESSION['mensagem']);
    }
    ?>

    <div class="container">
        <h2>Ambientes Cadastrados</h2>
        <form method="POST" action="./processar/processar_exclusaoambiente.php">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th>Imagem</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ambientes as $ambiente): ?>
                        <tr>
                            <td><?php echo $ambiente->id; ?></td>
                            <td><?php echo $ambiente->tipo; ?></td>
                            <td><?php echo $ambiente->nome; ?></td>
                            <td><img src="./processar/uploads/ambientes/<?= htmlspecialchars($ambiente->imagem) ?>"
                                alt="Imagem do Ambiente"></td>
                            <td>
                                <button type="submit" name="excluir_id" value="<?php echo $ambiente->id; ?>" class="btn-excluir">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>

    <footer>
        <?php include_once('./inc/rodape.inc.php'); ?>
    </footer>
</body>

</html>
