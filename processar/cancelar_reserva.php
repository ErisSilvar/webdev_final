<?php
require_once '../class/rb.php';
require_once '../inc/conexaobd.inc.php';
session_start();


if (!isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['reserva']) && isset($_GET['usuario_email'])) {
    $usuario_email = $_GET['usuario_email'];
    $reserva_id = $_GET['reserva'];


    $reserva = R::load('reservas', $reserva_id);


    if ($reserva->id && $reserva->usuario_email === $usuario_email) {
        R::trash($reserva);
        $_SESSION['mensagem'] = ['texto' => 'Reserva excluída com sucesso!', 'tipo' => 'sucesso'];
    } else {
        $_SESSION['mensagem'] = ['texto' => 'Você não tem permissão para cancelar essa reserva.', 'tipo' => 'erro'];
    }
} else {
    $_SESSION['mensagem'] = ['texto' => 'ID de exclusão não fornecido.', 'tipo' => 'erro'];
}

header('Location: ../minhasreservas.php');
exit();
?>