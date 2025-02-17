<?php
require_once '../class/rb.php';
require_once '../inc/conexaobd.inc.php';

session_start();

$usuario_email = $_SESSION['email']; 


if (isset($_POST['data_reserva'], $_POST['horario'], $_POST['ambiente_id'])) {
    $data_reserva = $_POST['data_reserva'];
    $horarios = $_POST['horario']; 
    $ambiente_id = $_POST['ambiente_id'];

    $ambiente = R::load('ambiente', $ambiente_id);
    if (!$ambiente->id) {
        $_SESSION['mensagem'] = ['texto' => 'Erro: Ambiente não encontrado.', 'tipo' => 'erro'];
        header('Location: ../reservar.php');
        exit;
    }

   
    foreach ($horarios as $horario) {
       
        $reserva_existente = R::findOne('reservas', 'data_reserva = ? AND ambiente_id = ? AND horario = ?', [$data_reserva, $ambiente_id, $horario]);

        if ($reserva_existente) {
            $_SESSION['mensagem'] = ['texto' => "Erro: O horário $horario já está reservado.", 'tipo' => 'erro'];
            header('Location: ../reservar.php');
            exit;
        }

        
        $reserva = R::dispense('reservas');
        $reserva->data_reserva = $data_reserva;
        $reserva->horario = $horario;
        $reserva->ambiente_id = $ambiente_id;
        $reserva->usuario_email = $usuario_email; 

        try {
            R::store($reserva); 
        } catch (Exception $e) {
            $_SESSION['mensagem'] = ['texto' => 'Erro ao realizar a reserva: ' . $e->getMessage(), 'tipo' => 'erro'];
            header('Location: ../reservar.php');
            exit;
        }
    }

    $_SESSION['mensagem'] = ['texto' => 'Reserva feita com sucesso!', 'tipo' => 'sucesso'];
    header('Location: ../minhasreservas.php');
    exit;
} else {
    $_SESSION['mensagem'] = ['texto' => 'Parâmetros de reserva inválidos.', 'tipo' => 'erro'];
    header('Location: ../reservar.php');
}
