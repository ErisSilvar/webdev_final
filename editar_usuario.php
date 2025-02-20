<?php
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('location: index.php');
    exit();
}

// Verifica se o ID foi passado pela URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Usuário não encontrado.'];
    header('location: gerenciaruser.php'); // Redireciona para a lista de usuários
    exit();
}

$id_usuario = $_GET['id'];

// Busca o usuário no banco de dados
$usuario = R::load('usuario', $id_usuario);

if (!$usuario->id) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Usuário não encontrado.'];
    header('location: gerenciaruser.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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
            max-width: 400px;
            width: 90%;
        }

        .container h2 {
            color: #2e7d32;
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
            width: 96%;
            padding: 10px;
            border: 1px solid #66bb6a;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group .check-admin {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .form-group .check-admin label {
            font-weight: normal;
            color: #2e7d32;
            cursor: pointer;
            margin-left: 0;
            margin-right: 90%;
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
            <h2>Editar Usuário</h2>
            <form action="./processar/processareditar_user.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
                
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario->nome); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario->email); ?>" required>
                </div>

                <div class="form-group">
                    <label for="senha">Nova Senha (deixe em branco para manter a atual):</label>
                    <input type="password" id="senha" name="senha">
                </div>

                <div class="form-group">
                    <div class="check-admin">
                        <input type="checkbox" id="admin" name="admin" value="1" <?php echo $usuario->admin ? 'checked' : ''; ?>>
                        <label for="admin">Administrador</label>
                    </div>
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
