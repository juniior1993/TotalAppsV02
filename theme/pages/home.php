<?php $v->layout("_theme"); ?>

    <div class="content">
        <h1 class="main-title">Home</h1>
        <div class="row">
            <div class="box-content w100">

                <div class="box-content-body">
                    <p class="content-box">
                        Novo layot para o TotalApps V 0.0.1

                    </p>
                </div>
            </div>

        </div>
    </div>

<?php $v->start("scripts"); ?>
    <script>
        window.onload = function () {
            setMenuActual("#sub-home", "not_a");
        };
        $(window).on('resize', function () {
            setMenuActual("#sub-home", "not_a");
        });

    </script>
<?php $v->end(); ?>