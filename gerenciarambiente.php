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
    <title>Gerenciar Ambientes</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/notificacao.css">
    <script src="https://kit.fontawesome.com/36842ecef1.js" crossorigin="anonymous"></script>
    <style>
        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 900px;
            width: 90%;
            overflow-x: auto;
            margin-top: 40px;
            padding-bottom: 20px;
        }

        .container h2 {
            color: #0c3468;
        }


        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            min-width: 600px;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            white-space: nowrap;
        }

        table th {
            background-color: #1f788c;
            color: white;
        }

        table td img {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }

        .btn-excluir,
        .btn-editar {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
            width: 30px;
            height: 30px;
            box-sizing: border-box;
        }

        .btn-excluir {
            background-color: #e53935;
            color: white;
        }

        .btn-excluir:hover {
            background-color: #c62828;
        }

        .btn-editar {
            background-color: rgb(25, 86, 219);
            color: white;
        }

        .btn-editar:hover {
            background-color: rgb(27, 68, 158);
        }

        .btn-excluir i,
        .btn-editar i {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .btn-excluir:hover i,
        .btn-editar:hover i {
            transform: scale(1.1);
        }



        @media screen and (max-width: 768px) {
            .container {
                padding: 15px;
            }

            table {
                min-width: 100%;
            }

            table th,
            table td {
                padding: 8px;
            }
        }

        @media screen and (max-width: 480px) {
            table {
                display: block;
                overflow-x: auto;
            }

            table th,
            table td {
                padding: 6px;
                font-size: 14px;
            }
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
            <h2>Ambientes Cadastrados</h2>
            <form method="POST" action="./processar/processar_exclusaoambiente.php">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Imagem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ambientes as $ambiente): ?>
                            <tr>
                                <td><?php echo $ambiente->id; ?></td>
                                <td><?php echo $ambiente->tipo; ?></td>
                                <td><?php echo $ambiente->nome; ?></td>
                                <td><?php echo $ambiente->descricao; ?></td>
                                <td><img src="./processar/uploads/ambientes/<?= htmlspecialchars($ambiente->imagem) ?>"
                                        alt="Imagem do Ambiente"></td>
                                <td>
                                    <button type="submit" name="excluir_id" value="<?php echo $ambiente->id; ?>"
                                        class="btn-excluir">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                    <a href="editar_ambiente.php?id=<?php echo $ambiente->id; ?>" class="btn-editar">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        </div>
    </main>

    <footer>
        <?php include_once('./inc/rodape.inc.php'); ?>
    </footer>
</body>

</html>