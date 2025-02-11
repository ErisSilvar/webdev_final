<?php
require_once './class/rb.php';
require_once './inc/conexaobd.inc.php';
include_once './inc/entradausuario.inc.php';
require_once './inc/testebd.inc.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre</title>
    <link rel="stylesheet" href="./style/style.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: rgb(37, 102, 29);
            padding: 20px;
            text-align: center;
            color: #aff;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        h1 {
            font-size: 2.5em;
            color: rgb(37, 102, 29);
            margin: 20px 0;
        }

        main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 100px;
        }

        h2 {
            font-size: 1.8em;
            color: rgb(37, 102, 29);
            margin-top: 40px;
            margin-bottom: 10px;
        }

        .p {
            text-indent: 2em;
        }

        .texto {
            text-align: center;
            font-size: 1.5em;
            color: rgb(37, 102, 29);
            margin-bottom: 30px;
        }

        .perfil-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .perfil {
            text-align: center;
            width: calc(33.33% - 20px);
            background-color: rgba(15, 80, 9, 0.33);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgb(0, 0, 0, 0.1);
            min-width: 250px;
        }

        .perfil p {
            margin: 10px 0;
            font-size: 1.1em;
        }

        .imagem {
            width: 180px;
            height: 180px;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid rgb(37, 102, 29);
            position: relative;
            z-index: 1;
        }

        footer {
            background-color: rgb(37, 102, 29);
            padding: 20px;
            text-align: center;
            color: #fff;
            margin-top: 40px;
            position: fixed;
            z-index: 1000;
        }
    </style>

</head>

<body>
    <header>
        <?php include_once './inc/cabecalho.inc.php' ?>
    </header>

    <main>
        <h1 class="texto">Sobre nós</h1>

        <div class="perfil-container">
            <div class="perfil">
                <p>Ana Cecília Silva </p>
                <img src="imgs/naceci.jpg" alt="Imagem de Ana" class="imagem">
                <p>Email de contato: cceci0170@gmail.com</p>
            </div>

            <div class="perfil">
                <p>Ana Julia Matos</p>
                <img src="imgs/naju.jpg" alt="Imagem de Julia" class="imagem">
                <p>Email de contato: ajms4@aluno.ifnmg.edu.br</p>
            </div>

            <div class="perfil">
                <p>Eris Silva</p>
                <img src="imgs/eris.jpg" alt="Imagem de Eris" class="imagem">
                <p>Email de contato: eers@aluno.ifnmg.edu.br</p>
            </div>

            <div class="perfil">
                <p>Hianca Rafaella</p>
                <img src="imgs/hianca.jpg" alt="Imagem de Hianca" class="imagem">
                <p>Email de contato: hrgo@aluno.ifnmg.edu.br </p>
            </div>

            <div class="perfil">
                <p>Maria Eduarda Carvalho</p>
                <img src="imgs/duda.jpg" alt="Imagem de Maria" class="imagem">
                <p>Email de Contato: mecss@aluno.ifnmg.edu.br</p>
            </div>
        </div>

        <h2>Sobre nós</h2>
        <p class="p">Somos uma equipe de alunos do Instituto Federal - Campus Montes Claros, aprendendo a desenvolver sites, na matéria de Desenvolvimento Web, cursando o 3° ano de Informática integrado ao Ensino Médio.</p>

    </main>

    <footer>
        <?php include_once './inc/rodape.inc.php' ?>
    </footer>
</body>

</html>