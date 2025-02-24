<?php
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';
require_once './inc/verificar_acesso.inc.php';

$usuario_email = $_SESSION['email'];

$reservas = R::find('reservas', 'usuario_email = ?', [$_SESSION['email']]);

$salas_reservadas = [];
$laboratorios_reservados = [];

foreach ($reservas as $reserva) {
    $ambiente = R::load('ambiente', $reserva->ambiente_id);
    if ($ambiente->tipo == 'sala') {
        $salas_reservadas[] = $reserva;
    } elseif ($ambiente->tipo == 'laboratorio') {
        $laboratorios_reservados[] = $reserva;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas reservas</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/notificacao.css">
    <style>
        .container {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 50px auto;
            text-align: center;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .card {
            width: 20%;
            background-color: rgba(255, 255, 255, 0.69);
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            text-align: center;
            padding: 15px;
            transition: background-color 0.4s ease, box-shadow 0.4s ease;
        }

        @media (max-width: 900px) {
            .card {
                width: calc(33.33% - 15px);

            }
        }

        @media (max-width: 600px) {
            .card {
                width: calc(50% - 15px);

            }
        }

        @media (max-width: 400px) {
            .card {
                width: 100%;

            }
        }

        .card:hover {
            background-color: rgba(167, 203, 212, 0.32);
            box-shadow: 0px 5px 15px rgba(61, 122, 128, 0.7);
        }

        .card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .card h3 {
            margin: 10px 0 5px;
            font-size: 1rem;
            color: #0c3468;
        }

        .card p {
            font-size: 0.9rem;
            color: #555;
        }

        .reserva_btn {
            background-color: rgb(237, 13, 13);
            color: white;
            font-size: 1rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .reserva_btn:hover {
            background-color: rgb(142, 56, 56);
            transform: scale(1.05);
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
            <h1>Minhas reservas</h1>
            <h1>Salas</h1>
            <?php if (count($salas_reservadas) > 0): ?>
                <div class="card-container">
                    <?php foreach ($salas_reservadas as $reserva):
                        $ambiente = R::load('ambiente', $reserva->ambiente_id);
                        ?>
                        <div class="card">
                            <img src="./processar/uploads/ambientes/<?= htmlspecialchars($ambiente->imagem) ?>"
                                alt="Imagem da Sala">
                            <h3><?= htmlspecialchars($ambiente->nome) ?></h3>
                            <p><b>Data: <?= (new DateTime($reserva->data_reserva))->format('d/m/Y') ?></b></p>
                            <p><b>Horário: <?= htmlspecialchars($reserva->horario) ?></b></p>
                            <a
                                href="./processar/cancelar_reserva.php?usuario_email=<?= $usuario_email ?>&reserva=<?= urlencode($reserva->id) ?>">
                                <button class="reserva_btn">Cancelar reserva</button>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mensagem-central">Nenhuma sala reservada.</p>
            <?php endif; ?>

            <h1>Laboratórios</h1>
            <?php if (count($laboratorios_reservados) > 0): ?>
                <div class="card-container">
                    <?php foreach ($laboratorios_reservados as $reserva):
                        $ambiente = R::load('ambiente', $reserva->ambiente_id);
                        ?>
                        <div class="card">
                            <img src="./processar/uploads/ambientes/<?= htmlspecialchars($ambiente->imagem) ?>"
                                alt="Imagem do Laboratório">
                            <h3><?= htmlspecialchars($ambiente->nome) ?></h3>
                            <p><b>Data: <?= (new DateTime($reserva->data_reserva))->format('d/m/Y') ?></b></p>
                            <p><b>Horário: <?= htmlspecialchars($reserva->horario) ?></b></p>
                            <a
                                href="./processar/cancelar_reserva.php?usuario_email=<?= $usuario_email ?>&reserva=<?= urlencode($reserva->id) ?>">
                                <button class="reserva_btn">Cancelar reserva</button>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mensagem-central">Nenhum laboratório reservado.</p>
            <?php endif; ?>

        </div>
    </main>
    <footer>
        <?php
        include_once('./inc/rodape.inc.php');
        ?>
    </footer>
</body>

</html>