<?php
require_once '../class/rb.php';
require_once '../inc/conexaobd.inc.php';


session_start();


if (!isset($_SESSION['email'])) {
    die("Erro: Usuário não autenticado. Por favor, faça login.");
}

$usuario_email = $_SESSION['email']; 


if (isset($_POST['data_reserva'], $_POST['horario'], $_POST['ambiente_id'])) {
    $data_reserva = $_POST['data_reserva'];
    $horario = $_POST['horario'];
    $ambiente_id = $_POST['ambiente_id'];


    $ambiente = R::load('ambiente', $ambiente_id);
    if (!$ambiente->id) {
        die("Erro: Ambiente não encontrado.");
    }


    $reserva_existente = R::findOne('reservas', 'data_reserva = ? AND ambiente_id = ? AND horario = ?', [$data_reserva, $ambiente_id, $horario]);

    if ($reserva_existente) {
        die("Erro: O horário já está reservado.");
    }


    $reserva = R::dispense('reservas');
    $reserva->data_reserva = $data_reserva;
    $reserva->horario = $horario;
    $reserva->ambiente_id = $ambiente_id;
    $reserva->usuario_email = $usuario_email; 

    try {
        R::store($reserva); 
        echo "Reserva realizada com sucesso!";
        header('Location: ../minhasreservas.php');
    } catch (Exception $e) {
        die("Erro ao realizar a reserva: " . $e->getMessage());
    }
} else {
    die("Erro: Parâmetros de reserva inválidos.");
}
?>
