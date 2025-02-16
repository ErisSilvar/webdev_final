<?php
require_once '../class/rb.php';
require_once '../inc/conexaobd.inc.php';
include_once('../inc/entradausuario.inc.php');

date_default_timezone_set('America/Sao_Paulo');

$dia = isset($_POST['dia']) ? (int) $_POST['dia'] : null;
$mes = isset($_POST['mes']) ? (int) $_POST['mes'] : null;
$ano = isset($_POST['ano']) ? (int) $_POST['ano'] : null;
$ambiente_id = isset($_POST['ambiente_id']) ? $_POST['ambiente_id'] : null;

if (!$dia || !$mes || !$ano || !$ambiente_id) {
    echo "<p>Dados insuficientes para exibir os horários.</p>";
    exit;
}

$data_selecionada = sprintf('%04d-%02d-%02d', $ano, $mes, $dia);
$data_atual = date('Y-m-d');

if ($data_selecionada < $data_atual) {
    echo "<p>Não é possível reservar datas passadas.</p>";
    exit;
}

$horarios_disponiveis = [];
for ($h = 8; $h <= 18; $h++) {
    $horarios_disponiveis[] = sprintf('%02d:00', $h);
}

$horarios_ocupados = R::getCol(
    "SELECT horario FROM reservas WHERE data_reserva = ? AND ambiente_id = ?",
    [$data_selecionada, $ambiente_id]
);

echo "<h3>Horários disponíveis para $dia/$mes/$ano</h3>";
echo "<form method='post' action='processar_reservar.php'>";
echo "<input type='hidden' name='data_reserva' value='$data_selecionada'>";
echo "<input type='hidden' name='ambiente_id' value='$ambiente_id'>";

echo "<div style='display: flex; flex-wrap: wrap; gap: 10px;'>";
foreach ($horarios_disponiveis as $horario) {
    $disabled = in_array($horario, $horarios_ocupados) ? "disabled style='background-color: red; color: white;'" : "";
    $mensagem = in_array($horario, $horarios_ocupados) ? "<br><small>Já reservado</small>" : "";
    echo "<label style='display: inline-block; padding: 10px; border: 1px solid #ccc; cursor: pointer;'>";
    echo "<input type='radio' name='horario' value='$horario' $disabled> $horario $mensagem";
    echo "</label>";
}
echo "</div>";

echo "<br><button type='submit'>Reservar</button>";
echo "</form>";
