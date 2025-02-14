<nav class="nav">
    <img src="./imgs/if_icone.png" alt="Logo do if" class="logo" width="40" height="40">
    <?= $linkHome ?>
    <?= $linkSobre ?>
    <?= $linkAdmin ?>

    <div class="elementos-php">
        <span class="apresentacao-user"><?= $mensagem ?></span>
        <button class="btn-usuario"><?= $logout, $fazer_login ?></button>
    </div>
</nav>