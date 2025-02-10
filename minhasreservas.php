<?php
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';

$usuario_id = $_SESSION['usuario'];

$reservas = R::find('reservas', 'id != ?', [1]);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas reservas</title>
    <link rel="stylesheet" href="./style/style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
         .container {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 50px auto;
            text-align: center;
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
    <div class="container">
        <h2>Suas reservas</h2>
        <form method="POST" action="./processar/processar_exclusao.php">
            <>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Ambiente</th>
                        <th>Nome de reservista</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?php echo $reserva->id; ?></td>
                            <td><?php echo $reserva->data_reserva; ?></td>
                            <td><?php echo $reserva->email; ?></td>
                            <td><?php echo $reserva->admin == 1 ? 'Administrador' : 'Usuário Comum'; ?></td>
                            <td>
                                <button type="submit" name="excluir_id" value="<?php echo $usuario->id; ?>" class="btn-excluir">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>
    </main>
    <footer>
        <?php
            include_once('./inc/rodape.inc.php');
        ?>
    </footer>
</body>
</html>