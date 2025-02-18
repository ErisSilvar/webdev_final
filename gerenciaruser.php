<?php
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
    header('location: index.php');
    exit();
}

$usuarioLogado = $_SESSION['email'];

$usuarios = R::find('usuario', 'id != ? AND email != ?', [1, $usuarioLogado]);


?>
<!DOCTYPE html>
<html lang="pt-BR"> 

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar usuários</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/notificacao.css">
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
            max-width: 50%;
            width: 100%;
            overflow-x: auto;

        }

        .container h2 {
            color: #2e7d32;
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
            <h2>Usuários Cadastrados</h2>
            <form method="POST" action="./processar/processar_exclusao.php">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo $usuario->id; ?></td>
                                <td><?php echo $usuario->nome; ?></td>
                                <td><?php echo $usuario->email; ?></td>
                                <td><?php echo $usuario->admin == 1 ? 'Administrador' : 'Usuário Comum'; ?></td>
                                <td>
                                    <button type="submit" name="excluir_id" value="<?php echo $usuario->id; ?>"
                                        class="btn-excluir">Excluir</button>
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