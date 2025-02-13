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
        .container {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 50px auto;
            text-align: center;
        }

        main {
            margin-top: 7%;
        }

        h1 {
            font-size: 2.5em;
            color: rgb(37, 102, 29);
            margin: 20px 0;
        }

        .texto {
            font-size: 1.3em;
            color: rgb(37, 102, 29);
            margin-bottom: 30px;
            text-align: justify;
        }

        .perfil-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
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
        }
    </style>

</head>

<body>
    <header>
        <?php include_once './inc/cabecalho.inc.php' ?>
    </header>

    <main>
        <div class="container">
            <h1 class="texto">Sobre a Equipe</h1>
            <p class="texto">
                Somos alunos do curso Técnico em Informática do IFNMG - Campus Montes Claros, e nosso objetivo é garantir o pleno funcionamento dos projetos que desenvolvemos ao longo de nossa trajetória acadêmica.
            </p>
            <p class="texto">
                Este é o nosso último trabalho na disciplina de Desenvolvimento Web, realizado no terceiro ano do curso, e marca nossa formatura em 2025. Ao longo do curso, aprendemos e aplicamos os conhecimentos adquiridos para criar soluções inovadoras na área da tecnologia.
            </p>
            <p class="texto">
                Este projeto reflete nosso empenho, dedicação e evolução contínua no campo da programação e desenvolvimento web. Ele é fruto do trabalho coletivo e da troca de experiências durante o curso, com o objetivo de criar uma solução que seja útil para muitos.
            </p>
            <p class="texto">
                Agradecemos a todos que nos acompanharam e apoiaram ao longo dessa jornada. Esperamos que este programa atenda às expectativas e contribua positivamente para aqueles que o utilizarem.
            </p>
            <div class="perfil-container">
                <div class="perfil">
                    <p>Ana Cecília Silva</p>
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
                    <p>Email de contato: hrgo@aluno.ifnmg.edu.br</p>
                </div>
                <div class="perfil">
                    <p>Maria Eduarda Carvalho</p>
                    <img src="imgs/duda.jpg" alt="Imagem de Maria" class="imagem">
                    <p>Email de contato: mecss@aluno.ifnmg.edu.br</p>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include_once './inc/rodape.inc.php' ?>
    </footer>
</body>

</html>
