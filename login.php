<?php
session_start();

require_once './inc/testebd.inc.php';

if (isset($_POST['login'])) {

    require_once './class/rb.php';
    include_once './inc/conexaobd.inc.php';

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario = R::findOne('usuario', 'email = ?', [$email]);

    if ($usuario && password_verify($senha, $usuario->senha)) {
        $_SESSION['nome'] = $usuario->nome;
        $_SESSION['email'] = $usuario->email;
        $_SESSION['admin'] = $usuario->admin;

        $_SESSION['exibir_boas_vindas'] = true;

        header("Location: index.php");
        exit();
    } else {
        $_SESSION['notificacao'] = [
            'tipo' => 'erro',
            'mensagem' => 'Email ou senha incorretos.'
        ];

    }
}

if (isset($_POST['visitante'])) {
    $_SESSION['nome'] = 'Visitante';
    $_SESSION['email'] = 'visitante@ifnmg.edu.br';
    $_SESSION['admin'] = 0;

    $_SESSION['exibir_boas_vindas'] = true;

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistema de Cadastro</title>
    <link rel="stylesheet" href="./style/notificacao.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url("./imgs/ifnmg_moc.jpg") no-repeat center center/cover;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            position: relative;
            z-index: 2;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 25%;
            margin-top: 50px;
            text-align: center;
        }

        .container h1 {
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
            width: 95%;
            padding: 10px;
            border: 1px solid #66bb6a;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-submit {
            width: 100%;
            margin-bottom: 10px;
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

    <div class="container">
        <h1>Login</h1>

        <?php if (isset($_SESSION['notificacao'])): ?>
            <div class="notificacao <?php echo $_SESSION['notificacao']['tipo']; ?>">
                <?php echo $_SESSION['notificacao']['mensagem']; ?>
            </div>
            <?php unset($_SESSION['notificacao']); ?>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit" name="login" class="btn-submit">Entrar</button>
        </form>
        <form action="login.php" method="POST">
            <input type="hidden" name="visitante" value="1">
            <button type="submit" class="btn-submit">Entrar como Visitante</button>
        </form>
    </div>

</body>

</html>