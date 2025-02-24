<?php
include_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';
require_once './inc/verificar_acesso.inc.php';

setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR', 'portuguese');

$ambiente_id = isset($_GET['ambiente']) ? $_GET['ambiente'] : null;

if (!$ambiente_id) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Parâmetros inválidos!'];
    header('Location: index.php');
    exit();
}

$usuario_email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$ambiente_id = isset($_GET['ambiente']) ? $_GET['ambiente'] : null;
$data = isset($_GET['mes']) ? $_GET['mes'] : date('Y-m');
$diasmes = date('t', strtotime($data));
$diassemana = date('w', strtotime($data));
$mesNome = strftime('%B', strtotime($data));



$horarios_disponiveis = [];
for ($h = 8; $h <= 18; $h++) {
    $horarios_disponiveis[] = sprintf('%02d:00', $h);
}

$dia_selecionado = isset($_GET['dia']) ? (int) $_GET['dia'] : null;
$horarios_ocupados = [];
if ($dia_selecionado) {
    $data_selecionada = sprintf('%04d-%02d-%02d', date('Y', strtotime($data)), date('m', strtotime($data)), $dia_selecionado);
    $horarios_ocupados = R::getCol(
        "SELECT horario FROM reservas WHERE data_reserva = ? AND ambiente_id = ?",
        [$data_selecionada, $ambiente_id]
    );
}

$reservas = R::find('reservas', 'data_reserva = ? AND ambiente_id = ?', [$data_selecionada, $ambiente_id]);

$horarios_ocupados = [];
foreach ($reservas as $reserva) {
    $usuario = R::findOne('usuario', 'email = ?', [$reserva->usuario_email]);
    $horarios_ocupados[$reserva->horario] = $usuario->nome;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário de Reservas</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/notificacao.css">
    <style>
        header {
            z-index: 10;
        }

        main {
            margin-top: 90px;
            position: relative;
        }

        table {
            margin-top: 20px;
        }

        .container {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(1, 17, 1, 0.42);
            max-width: 900px;
            margin: 50px auto;
            text-align: center;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            color: #222;
            font-weight: 600;
        }

        form {
            text-align: center;
            margin-bottom: 25px;
        }

        input[type="month"] {
            padding: 10px;
            font-size: 18px;
            margin-top: 12px;
            border: 1px solid #bbb;
            border-radius: 6px;
            background-color: #fff;
            transition: 0.3s;
        }

        input[type="month"]:hover {
            border-color: #888;
        }


        table {
            width: 100%;
            max-width: 850px;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            table-layout: fixed;
        }

        th,
        td {
            width: 14.28%;
            text-align: center;
            padding: 18px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        th {
            background-color: rgb(132, 164, 172);
            font-weight: bold;
            text-transform: uppercase;
        }


        td {
            position: relative;
        }

        td:hover {
            background-color: rgb(218, 232, 233);

            transform: scale(1);

            transition: all 0.3s ease;

        }

        td a {
            color: rgba(66, 54, 54, 0.88);
        }

        td a:hover {
            background-color: rgb(167, 203, 212);
            ;

            color: black;
            transform: scale(1.1);

            transition: all 0.3s ease;
        }

        td[style="color: grey;"] a:hover {
            background-color: transparent;
            box-shadow: none;
            transform: none;
        }

        td[style="color: grey;"] {
            background-color: #f2f2f2;
        }

        td[style="color: grey;"] a {
            cursor: not-allowed;
        }

        form div {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            justify-content: center;
            padding: 15px;
        }

        label {
            display: inline-block;
            padding: 18px;
            background-color: #fdfdfd;
            border: 1px solid #aaa;
            cursor: pointer;
            border-radius: 6px;
            transition: 0.3s;
            width: 85px;
            text-align: center;
            font-size: 16px;
        }

        label:hover {
            background-color: rgb(167, 203, 212);
        }

        input[type="radio"]:disabled+label {
            background-color: #ffcccc;
            color: #a00;
            cursor: not-allowed;
        }

        button {
            padding: 12px 24px;
            font-size: 18px;
            color: white;
            background-color: #1796b3;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #1f788c;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            table {
                width: 100%;
            }

            label {
                width: auto;
                padding: 12px;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include_once('inc/cabecalho.inc.php'); ?>
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
                    $hoje = date('Y-m-d');

                    for ($i = 0; $i < $diassemana; $i++) {
                        echo "<td></td>";
                    }


                    for ($dia = 1; $dia <= $diasmes; $dia++) {
                        $data_atual = sprintf('%04d-%02d-%02d', date('Y', strtotime($data)), date('m', strtotime($data)), $dia);

                        if ($usuario_email) {
                            if ($data_atual >= $hoje) {
                                echo "<td><a href='?dia=$dia&mes=$data&ambiente=$ambiente_id'>$dia</a></td>";
                            } else {
                                echo "<td style='color: grey;'>$dia</td>";
                            }
                        } else {
                            echo "<td>$dia</td>";
                        }

                        if (($dia + $diassemana) % 7 == 0) {
                            echo "</tr><tr>";
                        }
                    }
                    ?>

                </tr>
            </table>
            <?php if ($dia_selecionado): ?>
                <h2>Horários disponíveis para o dia
                    <?= $dia_selecionado ?>/<?= date('m', strtotime($data)) ?>/<?= date('Y', strtotime($data)) ?>
                </h2>
                <form method="post" action="./processar/processar_reserva.php">
                    <input type="hidden" name="data_reserva" value="<?= $data_selecionada ?>">
                    <input type="hidden" name="ambiente_id" value="<?= $ambiente_id ?>">
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">

                        <?php
                        $hoje = date('Y-m-d');
                        $hora_atual = date('H:i');
                        $hora_comparacao = sprintf('%02d:%02d', date('H'), 0);
                        foreach ($horarios_disponiveis as $horario):
                            $ocupado = isset($horarios_ocupados[$horario]);
                            $nome_usuario = $ocupado ? $horarios_ocupados[$horario] : '';
                            $passado = ($data_selecionada == $hoje) && ($horario < $hora_atual);

                            $disabled = ($ocupado || $passado) ? "disabled" : "";
                            $style = "";
                            $mensagem = "";
                            if ($ocupado) {
                                $style = "background-color: red; color: white;";
                                $mensagem = "<br><small>Já reservado por $nome_usuario</small>";
                            } elseif ($passado) {
                                $style = "background-color: grey; color: white;";
                                $mensagem = "<br><small>Horário indisponível</small>";
                            }
                            ?>
                            <label
                                style="display: inline-block; padding: 10px; border: 1px solid #ccc; cursor: pointer; <?= $style ?>">
                                <input type="checkbox" name="horario[]" value="<?= $horario ?>" <?= $disabled ?>> <?= $horario ?>
                                <?= $mensagem ?>
                            </label>
                        <?php endforeach; ?>


                    </div>
                    <br><button type="submit">Reservar</button>
                </form>
            <?php endif; ?>

        </div>
    </main>
    <footer>
        <?php include_once './inc/rodape.inc.php' ?>
    </footer>
</body>

</html>