<?php
require_once 'class/rb.php';
require_once './inc/conexaobd.inc.php';


if (isset($_GET['status']) && $_GET['status'] === 'success') {
    echo "Reserva realizada com sucesso!<br>";


    $usuario_email = $_SESSION['email'] ?? null;

    if ($usuario_email) {

        $reserva = R::findOne('reservas', 'usuario_email = ? ORDER BY id DESC LIMIT 1', [$usuario_email]);

        if ($reserva) {
            echo "Detalhes da reserva:<br>";
            echo "Data da reserva: " . $reserva->data_reserva . "<br>";
            echo "Horário: " . $reserva->horario . "<br>";
            echo "Ambiente ID: " . $reserva->ambiente_id . "<br>";
        } else {
            echo "Erro: Não foi possível encontrar a reserva no banco de dados.";
        }
    } else {
        echo "Erro: Não foi possível identificar o usuário.";
    }
} else {
    echo "Erro ao realizar a reserva. Tente novamente.";
}
?>