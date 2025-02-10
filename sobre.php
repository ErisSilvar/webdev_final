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
</head>

<body>
    <header>
        <?php include_once './inc/cabecalho.inc.php' ?>
    </header>

    <main>
        <h1>Sobre nós</h1>

        <div>
            <p>Ana Cecília Silva </p>
            <img src="imgs/naceci.jpg" alt="Imagem de Ana"></img>
            <p>Email de contato: cceci0170@gmail.com</p>
        </div>

        <div>
            <p>Ana Julia Matos</p>
            <img src="imgs/naju.jpg" alt="Imagem de Julia"></img>
            <p>Email de cotato: ajms4@aluno.ifnmg.edu.br</p>
        </div>

        <div>
            <p>Eris Silva</p>
            <img src="imgs/eris.jpg" alt="Imagem de Eris"></img>
            <p>Email de contato: eers@aluno.ifnmg.edu.br</p>
        </div>

        <div>
            <p>Maria Eduarda Carvalho</p>
            <img src="imgs/duda.jpg" alt="Imagem de Maria"></img>
            <p>Email de Contato: mecss@aluno.ifnmg.edu.br</p>
        </div>
    
        <h2>Sobre nós</h2>
        <p>Somos uma equipe de alunos do Instituto Federal - Campus Montes Claros, aprendendo a desenvolver sites, na matéria de Desenvolvimento Web, cursando o 3° ano de Informática integrado ao Ensino Médio.</p>
    </main>

    <footer>
        <?php include_once './inc/rodape.inc.php' ?>
    </footer>
</body>

</html>