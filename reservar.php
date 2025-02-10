<?php
require_once 'class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';

setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR', 'portuguese');

$usuario_id = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$ambiente_id = isset($_GET['ambiente']) ? $_GET['ambiente'] : null;
$data = isset($_GET['mes']) ? $_GET['mes'] : date('Y-m');
$diasmes = date('t', strtotime($data)); 
$diassemana = date('w', strtotime($data));
$mesNome = strftime('%B', strtotime($data)); 


$horarios_disponiveis = [];
for ($h = 8; $h <= 18; $h++) {
    $horarios_disponiveis[] = sprintf('%02d:00', $h);
}


$dia_selecionado = isset($_GET['dia']) ? (int)$_GET['dia'] : null;
$horarios_ocupados = [];
if ($dia_selecionado) {
    $data_selecionada = sprintf('%04d-%02d-%02d', date('Y', strtotime($data)), date('m', strtotime($data)), $dia_selecionado);
    $horarios_ocupados = R::getCol(
        "SELECT horario FROM reservas WHERE data_reserva = ? AND ambiente_id = ?",
        [$data_selecionada, $ambiente_id]
    );
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário de Reservas</title>
    <link rel="stylesheet" href="./estilo/style.css">
    <link rel="stylesheet" href="./estilo/notificacao.css">
    <style>
        table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            border-collapse: collapse;
        }
        th, td {
            width: 14.28%;
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
        }
        a {
            display: block;
            padding: 10px;
            border-radius: 5px;
            color: #2e7d32;
            text-decoration: none;
            background-color: #e0f7fa;
        }
        a:hover {
            background-color: #81d4fa;
        }
    </style>
</head>
<body>
    <header>
        <?php include_once('inc/cabecalho.inc.php'); ?>
    </header>
    <main>
        <h1>Calendário de Reservas</h1>
        <h2><?= ucfirst($mesNome) . " " . date('Y', strtotime($data)) ?></h2>

        <form method="get" action="reservar.php">
            <input type="hidden" name="ambiente" value="<?= $ambiente_id ?>">
            <label for="mes">Escolha o mês:</label>
            <input type="month" id="mes" name="mes" value="<?= $data ?>" onchange="this.form.submit()">
        </form>

        <table>
            <tr>
                <th>Dom</th>
                <th>Seg</th>
                <th>Ter</th>
                <th>Qua</th>
                <th>Qui</th>
                <th>Sex</th>
                <th>Sab</th>
            </tr>
            <tr>
                <?php
                for ($i = 0; $i < $diassemana; $i++) {
                    echo "<td>&nbsp;</td>";
                }

                for ($i = 1; $i <= $diasmes; $i++) {
                    if ($usuario_id) {
                        echo "<td><a href='?dia=$i&mes=$data&ambiente=$ambiente_id'>$i</a></td>";
                    } else {
                        echo "<td>$i</td>";
                    }
                    if (($i + $diassemana) % 7 == 0) {
                        echo "</tr><tr>";
                    }
                }

                for ($i = 0; $i < (7 - (($diasmes + $diassemana) % 7)); $i++) {
                    echo "<td>&nbsp;</td>";
                }
                ?>
            </tr>
        </table>

        <?php if ($dia_selecionado): ?>
            <h3>Horários disponíveis para o dia <?= $dia_selecionado ?>/<?= date('m', strtotime($data)) ?>/<?= date('Y', strtotime($data)) ?></h3>
            <form method="post" action="./processar/processar_reserva.php">
                <input type="hidden" name="data_reserva" value="<?= $data_selecionada ?>">
                <input type="hidden" name="ambiente_id" value="<?= $ambiente_id ?>">

                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    <?php foreach ($horarios_disponiveis as $horario): ?>
                        <?php
                        $disabled = in_array($horario, $horarios_ocupados) ? "disabled style='background-color: red; color: white;'" : "";
                        $mensagem = in_array($horario, $horarios_ocupados) ? "<br><small>Já reservado</small>" : "";
                        ?>
                        <label style="display: inline-block; padding: 10px; border: 1px solid #ccc; cursor: pointer;">
                            <input type="radio" name="horario" value="<?= $horario ?>" <?= $disabled ?>> <?= $horario ?> <?= $mensagem ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <br><button type="submit">Reservar</button>
            </form>
        <?php endif; ?>
    </main>
</body>
</html>
