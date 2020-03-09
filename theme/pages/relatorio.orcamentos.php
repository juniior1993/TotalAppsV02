<?php $v->layout("_theme"); ?>


<div class="content">
    <h1 class="main-title">Orçamentos</h1>
    <div class="row">
        <div class="box-content w100" id="box-pesquisa">
            <div class="box-content-header">
                Pesquisa
            </div>
            <div class="box-content-body">
                <form action="" id="search-date">
                    <div class="row-form">
                        <div class="form-group">
                            <label class="label" for="dataIni">Data Inicial</label>
                            <i class="far fa-calendar-alt inside-icon"></i>
                            <input type="text" class="flatpickr flatpickr-input" placeholder="00/00/0000"
                                   name="dataIni" value="<?= $dataInicial ?? '' ?>">
                        </div>
                        <div class="form-group">
                            <label class="label" for="dataFim">Data Final</label>
                            <i class="far fa-calendar-alt inside-icon"></i>
                            <input type="text" class="flatpickr flatpickr-input" placeholder="00/00/0000"
                                   name="dataFim" value=<?= $dataFinal ?? '' ?>"">
                        </div>
                        <div class="form-group">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="box-content w100" id="box-result" data-action="<?= $router->route("chart.orcamento") ?>">
            <div class="box-content-header box-flex-between">
                <div>Resultado</div>
                <i class="fas fa-search-plus inside-icon" id="iconNewSearch"></i>
            </div>
            <div class="box-content-body">
                <div class="chart">
                    <div class="box-content" style="width: 300px">
                        <canvas id="chart-statusComercial" width="300" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="box-content w100">
            <div class="box-content-header">
                Filtros
            </div>
            <div class="box-content-body">
                <form action="#" id="filters">
                    <div class="row-form">
                        <div class="form-group">
                            <label class="label" for="dataFim">Consultor</label>
                            <select class="basic">
                                <option value="">Selecione ...</option>
                                <option>Tamires Sales</option>
                                <option>Isabel Tselikas</option>
                                <option>Carlos Cruz</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="label" for="tipo">Tipo</label>
                            <select class="basic">
                                <option value="">Selecione ...</option>
                                <option>Juramentada</option>
                                <option>Simples</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="label" for="tipo">Aprovado</label>
                            <select class="basic">
                                <option value="">Selecione ...</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="form-group">
                            <label class="label" for="tipo">De</label>
                            <select class="basic">
                                <option value="">Selecione ...</option>
                                <option>Inglês</option>
                                <option>Português</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="label" for="tipo">Para</label>
                            <select class="basic">
                                <option value="">Selecione ...</option>
                                <option>Inglês</option>
                                <option>Português</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="box-content w100">
            <div class="box-content-header">
                Ultimos Orcamentos Realizados.
            </div>
            <div class="box-content-body">
                <table class="table t-100 responsive">
                    <thead>
                    <tr>
                        <th>Projeto</th>
                        <th>Consultor</th>
                        <th>Data Orçamento</th>
                        <th>Status Comercial</th>
                        <th>Data Aprovação</th>
                        <th>Valor</th>
                        <th>Palavras</th>
                        <th>De</th>
                        <th>Para</th>
                        <th>Tipo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($listOrcamentos->listOrcamentos()): ?>
                        <?php /** @var \Source\Models\ListOrcamentos $listOrcamentos */ ?>
                        <?php /** @var \Source\Models\Comercial $projeto */ ?>
                        <?php foreach ($listOrcamentos->listOrcamentos() as $projeto): ?>
                            <tr class="<?= $projeto->statusComercial(); ?>">
                                <?php $idioma = $projeto->idiomas(); ?>
                                <td class="center"><?= $projeto->COM_IndexProjeto; ?></td>
                                <td class="center"><?= $projeto->consultor()->REC_ApelidoRecurso; ?></td>
                                <td class="center"><?= $projeto->dataCadastro(); ?></td>
                                <td class="center"><?= $projeto->statusComercial(); ?></td>
                                <td class="center"><?= $projeto->dataAprovacao(); ?></td>
                                <td class="center">R$ <?= $projeto->COM_Total; ?></td>
                                <td class="center"><?= $projeto->somaArquivos(); ?></td>
                                <td class="center"><?= $idioma["idiomaDe"]; ?></td>
                                <td class="center"><?= $idioma["idiomaPara"]; ?></td>
                                <td class="center"><?= $projeto->tipoTraducaoGeral(); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php $v->start("scripts"); ?>
<script src="<?= assets("/js/flatpickr.js"); ?>"></script>
<script src="<?= assets("/js/chartJs.js"); ?>"></script>
<script src="<?= assets("/js/fancySelect.js"); ?>"></script>
<script>
    window.onload = function () {
        $(".flatpickr").flatpickr({enableTime: false, dateFormat: "d/m/Y"});
        setMenuActual("#sub-financeiro", "#a-orcamentos");

        $('.basic').fancySelect();

        let url = $("#box-result").data().action;
        Chart.defaults.global.defaultFontColor = '#74788D';
        Chart.defaults.global.defaultFontSize = 10;

        $.ajax({
            url: url,
            data: {'dateIni': '2020-02-01'},
            type: "get",
            dataType: "json",
            beforeSend: function (e) {

            },
            success: function (response) {

                let total = response['statusComercial']['Aprovado'] + response['statusComercial']['Recusada'] + response['statusComercial']['Cancelado'] + response['statusComercial']['Proposta'];

                var dataSet = {
                    'datasets': [{
                        'data': [
                            response['statusComercial']['Aprovado'],
                            response['statusComercial']['Recusada'],
                            response['statusComercial']['Cancelado'],
                            response['statusComercial']['Proposta']
                        ],
                        backgroundColor: ["greenyellow", "orange", "red", "#103ccc"],
                        borderColor: "#1A1E27"
                    }],

                    'labels': [
                        'Aprovado (' + ((response['statusComercial']['Aprovado'] / total) * 100).toFixed(2) + '%)',
                        'Recusado (' + ((response['statusComercial']['Recusada'] / total) * 100).toFixed(2) + '%)',
                        'Cancelado (' + ((response['statusComercial']['Cancelado'] / total) * 100).toFixed(2) + '%)',
                        'Proposta (' + ((response['statusComercial']['Cancelado'] / total) * 100).toFixed(2) + '%)'
                    ]
                };

                var ctx = document.getElementById('chart-statusComercial')
                var myPieChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: dataSet,
                    options: {
                        responsive: false
                    }
                });
                console.log(response['statusComercial']);
            },
            error: function (response) {
                return response;
            }
        });

        $("body").on("click", "#iconNewSearch", function () {
            $("#box-result").slideUp(500);
            $("#box-pesquisa").slideDown(500);
        });


    };

    $(window).on('resize', function () {
        setMenuActual("#sub-financeiro", "#a-orcamentos");
    });
</script>
<?php $v->end(); ?>

<?php $v->start("style"); ?>
<link rel="stylesheet" href="<?= assets("/css/flatpickr.css"); ?>">
<link rel="stylesheet" href="<?= assets("/css/fancySelect.css"); ?>">


<style>
    #box-result {
        display: block;
    }

    #box-pesquisa {
        display: none;
    }
</style>

<?php $v->end(); ?>
