    <?php
    require_once './class/rb.php';
    require_once './inc/conexaobd.inc.php';

    $tabelaExiste = false;
    $temAdmin = false;

    try {
        $tabelaExiste = R::count('usuario') >= 0;
        if ($tabelaExiste) {
            $temAdmin = R::count('usuario', 'admin = ?', [1]) > 0;
        }
    } catch (Exception $e) {
        $tabelaExiste = false;
    }

    if (!$tabelaExiste || !$temAdmin) {
        header('Location: ./cargainicial.php');
        exit;
    }

    ?>