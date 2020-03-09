<?php verifyLogin(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />

    <script src="https://kit.fontawesome.com/718e42f4f3.js" crossorigin="anonymous"></script>

    <!-- SCRIPTS -->
    <script src="<?= assets("/js/jQuery.min.js"); ?>"></script>
    <script src="<?= assets("/js/jquery-ui.min.js"); ?>"></script>
    <script src="<?= assets("/js/dashboard.js"); ?>"></script>


    <!--    STYLES -->
    <link rel="stylesheet" href="<?= assets("/css/style.css"); ?>" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet" />
    <?= $v->section("style"); ?>

    <title><?= $title ?? 'TotalApps' ?></title>
</head>

<body>
<!--loader-content-->
<div class="" id="carregaLoader">
    <div class="loader"></div>
</div>

<div id="message"></div>
    <div class="sidebar">
        <div class="topo">
            <div class="logo">
                <img src="<?= assets("/image/logo.png"); ?>" alt="Total Apps" />
            </div>
        </div>
        <div class="menu">
            <div class="container-items">
                <div class="item" data-action="<?= $router->route("web.home") ?>">
                    <i class="fas fa-home" title="Home"></i>
                    <div class="text-menu">Home</div>
                </div>
                <div class="sub-items" id="sub-home">

                </div>
            </div>
            <div class="container-items">
                <div class="item">
                    <i class="fas fa-file-invoice-dollar" title="Financeiro"></i>
                    <div class="text-menu">Testes</div>
                </div>
                <div class="sub-items" id="sub-testes">
                    <div class="text-sub-menu"><a href="<?= $router->route("teste.orcamento") ?>" id="a-teste-orcamentos">Teste Orçamentos</a></div>

                </div>
            </div>
            <div class="container-items">
                <div class="item">
                    <i class="fas fa-file-invoice-dollar" title="Financeiro"></i>
                    <div class="text-menu">Financeiro</div>
                </div>
                <div class="sub-items" id="sub-financeiro">
                    <div class="text-sub-menu"><a href="<?= $router->route("relatorio.orcamento") ?>" id="a-orcamentos">Orçamentos</a></div>
                    <div class="text-sub-menu"><a href="#">Vendas Particular</a></div>
                    <div class="text-sub-menu"><a href="#">Financeiro</a></div>
                </div>
            </div>
            <div class="container-items">
                <div class="item">
                    <i class="fas fa-project-diagram" title="Projetos"></i>
                    <div class="text-menu">Projetos</div>
                </div>
                <div class="sub-items">
                    <div class="text-sub-menu"><a href="#">Orçamentos</a></div>
                    <div class="text-sub-menu"><a href="#">Vendas Particular</a></div>
                    <div class="text-sub-menu"><a href="#">Financeiro</a></div>
                </div>
            </div>
            <div class="container-items">
                <div class="item">
                    <i class="fab fa-buffer" title="Utilitarios"></i>
                    <div class="text-menu">Utilitarios</div>
                </div>
            </div>

        </div>

        <div class="footer">
            <i class="fas fa-power-off" title="Sair" id="logoff"></i>
        </div>
    </div>

    <div class="main-container">
        <div class="header">
            <div class="welcome">Bem vindo, <b><?= $user->first_name ?> <?= $user->last_name ?></b></div>
            <div class="menu">
                <i class="fas fa-bars" id="show-right-bar"></i>
            </div>
        </div>

        <?= $v->section("content"); ?>

    </div>

    <div class="right-bar" id="right-bar">
        <i class="fas fa-bars" id="hide-right-bar"></i>
    </div>
<script src="<?= assets("/js/functions.js"); ?>"></script>
<?= $v->section("scripts"); ?>

</body>

</html>