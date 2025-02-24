<?php
include_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';
require_once './inc/verificar_acesso.inc.php';

// Verifica se a data, ambiente e horário foram passados pela URL
$dia = isset($_GET['dia']) ? (int) $_GET['dia'] : null;
$mes = isset($_GET['mes']) ? $_GET['mes'] : null;
$ambiente_id = isset($_GET['ambiente']) ? $_GET['ambiente'] : null;
$horario = isset($_GET['horario']) ? $_GET['horario'] : null;

// Verificação de parâmetros na URL
if (!$dia || !$mes || !$ambiente_id || !$horario) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Parâmetros inválidos!'];
    header('Location: index.php');
    exit();
}

// Formata a data de reserva (YYYY-MM-DD)
$data_reserva = sprintf('%04d-%02d-%02d', date('Y', strtotime($mes)), date('m', strtotime($mes)), $dia);

// Depuração: Exibe as variáveis para garantir que tudo está correto
echo "<pre>";
var_dump($data_reserva, $ambiente_id, $horario);
echo "</pre>";

// Busca a reserva para o dia e horário específicos
$reserva = R::findOne('reservas', 'data_reserva = ? AND ambiente_id = ? AND horario = ?', [$data_reserva, $ambiente_id, $horario]);

if ($reserva) {
    // Se a reserva foi encontrada, busca as informações do usuário
    $usuario = R::findOne('usuario', 'email = ?', [$reserva->usuario_email]);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Reserva</title>
    <link rel="stylesheet" href="./style/style.css">
    <style>
        .container {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(1, 17, 1, 0.42);
            max-width: 900px;
            margin: 50px auto;
            text-align: center;
        }

        h1 {
            color: #222;
        }

        .info {
            margin-top: 20px;
        }

        .info p {
            font-size: 1.2rem;
            color: #555;
        }

        .btn-voltar {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1796b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-voltar:hover {
            background-color: #1f788c;
        }
    </style>
</head>

<body>
    <header>
        <?php include_once('inc/cabecalho.inc.php'); ?>
    </header>
    <main>
        <div class="container">
            <h1>Detalhes da Reserva</h1>

            <?php if ($reserva && $usuario): ?>
                <div class="info">
                    <p><b>Data:</b> <?= date('d/m/Y', strtotime($data_reserva)) ?></p>
                    <p><b>Horário:</b> <?= htmlspecialchars($horario) ?></p>
                    <p><b>Nome do usuário:</b> <?= htmlspecialchars($usuario->nome) ?></p>
                    <p><b>E-mail:</b> <?= htmlspecialchars($usuario->email) ?></p>
                </div>
            <?php else: ?>
                <p>Não há reserva para este horário.</p>
            <?php endif; ?>

            <a href="reservar.php?ambiente=<?= $ambiente_id ?>&mes=<?= $mes ?>" class="btn-voltar">Voltar ao calendário</a>
        </div>
    </main>
    <footer>
        <?php include_once './inc/rodape.inc.php' ?>
    </footer>
</body>

</html>
