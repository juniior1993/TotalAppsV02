<?php $v->layout("_theme"); ?>

    <div class="content">
        <h1 class="main-title">Home</h1>
        <div class="row">
            <div class="box-content w100">

                <div class="box-content-body">
                    <p class="content-box">
                        Novo layot para o TotalApps V 0.0.1

                        <?php

                        var_dump($router->route("chart.orcamento"));
                        ?>

                    </p>
                </div>
            </div>

        </div>
    </div>

<?php $v->start("scripts"); ?>
    <script>
        window.onload = function () {

            // $("#carregaLoader").addClass("loader-content");

            let url = `http://localhost/template_total/api_relatorios/chartOrcamento`;

            let data = {dataIni:"2020-02-01"};

            let result = custom_ajax(url, data, "GET");
            console.log(url);
            setMenuActual("#sub-testes", "a-teste-orcamentos");
        };
        $(window).on('resize', function () {
            setMenuActual("#sub-testes", "a-teste-orcamentos");
        });

    </script>
<?php $v->end(); ?>