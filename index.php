<?php
include_once './inc/entradausuario.inc.php';
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
require_once './inc/testebd.inc.php';

$usuario_id = isset($_POST['usuario']);
$salas = R::findAll('ambiente', 'tipo = ?', ['sala']);
$laboratorios = R::findAll('ambiente', 'tipo = ?', ['laboratorio']);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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

        .reservar_btn {
            background-color: #1796b3;
            color: white;
            font-size: 1rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .reservar_btn:hover {
            background-color: rgb(27, 126, 148);
        }
    </style>
</head>

<body>
    <header>
        <?php include_once './inc/cabecalho.inc.php'; ?>
    </header>
    <main>
        <?php if (isset($_SESSION['exibir_boas_vindas']) && $_SESSION['exibir_boas_vindas']): ?>
            <div class="notificacao sucesso">
                Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!
            </div>
            <?php unset($_SESSION['exibir_boas_vindas']); ?>
        <?php endif; ?>


        <?php if (isset($_SESSION['msg_visitanteNegado'])): ?>
            <div class="notificacao erro">
                <p><?= htmlspecialchars($_SESSION['msg_visitanteNegado']['texto']) ?></p>
            </div>
            <?php unset($_SESSION['msg_visitanteNegado']); ?>
        <?php endif; ?>

        <?php

        if (isset($_SESSION['mensagem'])) {
            $mensagem = $_SESSION['mensagem'];
            echo "<div class='notificacao {$mensagem['tipo']}'>{$mensagem['texto']}</div>";
            unset($_SESSION['mensagem']);
        }
        ?>

        <div class="container">
            <h1>Reserva de Ambiente</h1>
            <h1>Salas</h1>
            <?php if (count($salas) > 0): ?>
                <div class="card-container">
                    <?php foreach ($salas as $sala): ?>
                        <div class="card">
                            <img src="./processar/uploads/ambientes/<?= htmlspecialchars($sala->imagem) ?>"
                                alt="Imagem da Sala">
                            <h3><?= htmlspecialchars($sala->nome) ?></h3>
                            <p><?= htmlspecialchars($sala->descricao) ?></p>
                            <button class="reservar_btn"
                                onclick="location.href='reservar.php?usuario_id=<?= $usuario_id ?>&ambiente=<?= urlencode($sala->id) ?>'">
                                Reservar
                            </button>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mensagem-central">Nenhuma sala encontrada.</p>
            <?php endif; ?>

            <h1>Laboratórios</h1>
            <?php if (count($laboratorios) > 0): ?>
                <div class="card-container">
                    <?php foreach ($laboratorios as $laboratorio): ?>
                        <div class="card">
                            <img src="./processar/uploads/ambientes/<?= htmlspecialchars($laboratorio->imagem) ?>"
                                alt="Imagem do Laboratório">
                            <h3><?= htmlspecialchars($laboratorio->nome) ?></h3>
                            <p><?= htmlspecialchars($laboratorio->descricao) ?></p>
                            <button class="reservar_btn"
                                onclick="location.href='reservar.php?usuario_id=<?= $usuario_id ?>&ambiente=<?= urlencode($laboratorio->id) ?>'">
                                Reservar
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mensagem-central">Nenhum laboratório encontrado.</p>
            <?php endif; ?>
        </div> 
    </main>
    <footer>
        <?php include_once './inc/rodape.inc.php'; ?>
    </footer>
</body>

</html>