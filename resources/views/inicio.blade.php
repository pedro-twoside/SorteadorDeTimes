<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <?php
        $controller = new \App\Http\Controllers\Controller();
        $jogadoresCtl = new \App\Http\Controllers\jogadoresCtl();
        $logo = $controller->getTreatedImage('soccer-ball-png-21.png');
        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sorteador Times</title>
        <link rel="icon" href="{{$logo}}" />

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

        <style>
            body { font-family: 'Nunito', sans-serif; background: #f7fafc}
            .mt-inicial{margin-top: 4%}
            .titulo{font-weight: 900; font-size: 24px}
            .pretitulo{font-weight: 900; font-size: 20px}
            .presubtitulo{font-weight: 500; font-size: 17px}
            .pretitulo{font-weight: 900; font-size: 20px}
            .subtitulo{font-size: 16px}
            .text-left{text-align: left}
            .text-right{text-align: right}
            .text-center{text-align: center}
            .sombra{box-shadow: 0 1px 3px 0 rgb(0 0 0 / 10%), 0 1px 2px 0 rgb(0 0 0 / 6%);}
            .botao{background: #fff; border-radius: 10px}
            .nav-link{color: #000 !important;}
            .mr-5{margin-right: 5px}
            .mtop-5{margin-top: 5px}
            .mtop-15{margin-top: 15px}
            .mtop-30{margin-top: 30px}
            .nav-item:hover{opacity: 0.5;cursor: pointer;}
            .peq{font-size: 10px !important;padding: 2px 10px !important;}
            .padd-box{padding: 20px !important;}
            .select2-selection .select2-selection--multiple{border: 1px solid #ced4da !important;}
            .black-bg{background: #212529 !important; color: #fff !important;}
            .bigbtn{
                font-size: 20px;
                padding: 20px 10px;
                text-align: center;
                background: #CFD8DC;
                color: #455A64;
                border-radius: 7px;
                text-decoration: none;
                margin-right: 10px;
            }
            .bgbtn-tx{
                color: #455A64;
            }
            .cp:hover{cursor:pointer;}
            .cp{text-decoration: none}
            .select2 .select2-container .select2-container--default .select2-container--focus{
                width: 100% !important;
            }

            @media (max-width: 991px) {
                .text-left{text-align: center}
                .text-right{text-align: center}
                .justify-content-end{justify-content: center !important;}
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">

                <!-- @pedroLara - PAGE HEADER -->
                <div class="col-lg-12 mt-inicial">
                    <div class="row">
                        <div class="col-lg-1 text-center">
                            <img src="{{$logo}}" style="width: 62px; height: 62px">
                        </div>
                        <div class="col-lg-5 text-left">
                            <span class="titulo">Pedro Lara</span><br>
                            <span class="subtitulo">Sorteador de Times</span>
                        </div>
                        <div class="col-lg-6">
                            <ul class="nav justify-content-end mtop-5">
                                <li class="nav-item botao sombra" id="btnInicio">
                                    <a class="nav-link" onclick="abreAba('inicio')">Início</a>
                                </li>
                                <li class="nav-item" id="btnJogadores">
                                    <a class="nav-link" onclick="abreAba('jogadores')">Jogadores</a>
                                </li>
                                <li class="nav-item" id="btnNovoSorteio">
                                    <a class="nav-link" onclick="abreAba('sorteio')"><i class="bi bi-plus-circle mr-5"></i> Novo Sorteio</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- @pedroLara - DASHBOARD -->
                <div class="col-lg-12 mt-inicial sombra botao padd-box" id="divInicio">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if($jogadoresCtl->getQtdPlayers() == 0){ ?>
                            <div class="alert alert-warning text-center" role="alert"><i class="bi bi-info-circle mr-5"></i> Não existem jogadores registrados, registre-os para sortear times.</div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row" style="padding: 0px 10px">
                        <div class="col-lg-4 bigbtn">
                            <a onclick="abreAba('jogadores')" class="cp">
                                <div class="bgbtn-tx"><i class="bi bi-people-fill"></i> Jogadores</div>
                            </a>
                        </div>

                        <div class="col-lg-4 bigbtn">
                            <a onclick="abreAba('sorteio')" class="cp">
                                <div class="bgbtn-tx"><i class="bi bi-dice-5"></i> Novo Sorteio</div>
                            </a>
                        </div>
                    </div>

                    <hr style="opacity: 0.1">

                    <div><span class="pretitulo">Jogadores por Níveis</span></div>
                    <div class="row mtop-15">
                        <div class="col-lg-12">
                            <div id="chartdiv" style="width: 100%; height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <!-- @pedroLara - PLAYERS -->
                <div class="col-lg-12 mt-inicial sombra botao padd-box d-none" id="divJogadores">
                    <div><span class="pretitulo">Jogadores</span></div>

                    <div class="row mtop-15">
                        <div class="col-lg-4">
                            <div class="mb-3"><span id="jogadores_form_titulo" class="presubtitulo">Adicionar</span></div>
                            <form id="formJogadores" class="mtop-5">
                                @csrf
                                <input type="hidden" id="editar_jogadores" name="editar_jogadores" value="N">
                                <input type="hidden" id="id_jogador" name="id_jogador" value="N">

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="nome_jogador" name="nome_jogador" placeholder="-" required>
                                    <label for="nome_jogador">Nome e Sobrenome</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="nivel_jogador" name="nivel_jogador" aria-label="" required>
                                        <option value="1">1 - Péssimo</option>
                                        <option value="2">2 - Ruim</option>
                                        <option value="3">3 - Mediano</option>
                                        <option value="4">4 - Bom</option>
                                        <option value="5">5 - Excelente</option>
                                    </select>
                                    <label for="floatingSelect">Nivel do Jogador</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="goleiro_jogador" name="goleiro_jogador" aria-label="" required>
                                        <option value="0">Não</option>
                                        <option value="1">Sim</option>
                                    </select>
                                    <label for="floatingSelect">O jogador é goleiro?</label>
                                </div>

                                <button type="submit" class="btn btn-dark" id="btnEnviaFormJogadores"><i class="bi bi-check-circle"></i> Concluir</button>
                                <a class="btn btn-light d-none" onclick="concluiJogadores()" id="btnCancelaFormJogadores" style="color: red;background: transparent;border: 0px">Cancelar Edição</a>
                            </form>
                        </div>

                        <div class="col-lg-8">
                            <div class="text-center mb-3"><span class="presubtitulo">Jogadores Registrados</span></div>
                            <div id="divListaJogadores"></div>
                        </div>
                    </div>
                </div>

                <!-- @pedroLara - PRIZE -->
                <div class="col-lg-12 mt-inicial sombra botao padd-box d-none" id="divSorteio">
                    <div><span class="pretitulo">Novo Sorteio</span></div>

                    <div class="row mtop-15">
                        <div class="col-lg-4">
                            <div class="mb-3"><span class="presubtitulo">Informações Iniciais</span></div>
                            <form id="formSorteio" class="mtop-5">
                                @csrf

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="numero" name="numero" placeholder="-" required>
                                    <label for="nome_jogador">Número de Jogadores por Time</label>
                                </div>
                                <div class=" mb-3">
                                    <label for="floatingSelect">Jogadores Com Presença Confirmada</label>
                                    <select class="form-select" id="selectJogadores" name="selectJogadores[]" multiple required></select>
                                </div>

                                <button type="submit" class="btn btn-dark"><i class="bi bi-dice-5"></i> Sortear Times</button>
                            </form>
                        </div>

                        <div class="col-lg-8">
                            <div class="text-center mb-3"><span class="presubtitulo">Resultado</span></div>
                            <div id="divTimes">
                                <div class="alert alert-dark text-center" role="alert"><i class="bi bi-info-circle mr-5"></i> Preencha os dados iniciais ao lado e clique em sortear para ver os times.</div>


                            </div>
                        </div>

                        <div class="col-lg-12">
                            <hr>
                            <span style="color: #9E9E9E"><i class="bi bi-info-circle mr-5"></i> <strong>Cálculo dos coeficientes</strong> é dado pela média aritimética do somatório dos níveis de cada jogador no time, dividido pela quantidade de jogadores.</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </body>
    <footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
        <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
        <script src="https://cdn.amcharts.com/lib/4/themes/dataviz.js"></script>
        <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

        <script>
            var token = '{{ csrf_token() }}';
            var spinner = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            function carregando() {Swal.fire({position: 'center',icon: 'info',title: 'Aguarde...',allowOutsideClick: false,showConfirmButton: false});}
            function carregou() {Swal.close();}

            $(document).ready(function() {
               concluiJogadores();
            });

            function abreAba(aba){
                if(aba == 'sorteio'){
                    $('#divSorteio').removeClass('d-none');
                    $('#divInicio').addClass('d-none');
                    $('#divJogadores').addClass('d-none');

                    $('#btnNovoSorteio').addClass('botao');
                    $('#btnNovoSorteio').addClass('sombra');

                    $('#btnInicio').removeClass('botao');
                    $('#btnInicio').removeClass('sombra');

                    $('#btnJogadores').removeClass('botao');
                    $('#btnJogadores').removeClass('sombra');


                } else if(aba == 'jogadores'){
                    $('#divJogadores').removeClass('d-none');
                    $('#divSorteio').addClass('d-none');
                    $('#divInicio').addClass('d-none');

                    $('#btnNovoSorteio').removeClass('botao');
                    $('#btnNovoSorteio').removeClass('sombra');

                    $('#btnInicio').removeClass('botao');
                    $('#btnInicio').removeClass('sombra');

                    $('#btnJogadores').addClass('botao');
                    $('#btnJogadores').addClass('sombra');

                } else if(aba == 'inicio'){
                    $('#divInicio').removeClass('d-none');
                    $('#divSorteio').addClass('d-none');
                    $('#divJogadores').addClass('d-none');

                    $('#btnNovoSorteio').removeClass('botao');
                    $('#btnNovoSorteio').removeClass('sombra');

                    $('#btnInicio').addClass('botao');
                    $('#btnInicio').addClass('sombra');

                    $('#btnJogadores').removeClass('botao');
                    $('#btnJogadores').removeClass('sombra');

                }
            }

            function concluiJogadores(){
                carregaTabelaJogadores();
                $('#formJogadores').each (function(){ this.reset(); });
                $('#editar_jogadores').val('N');
                $('#jogadores_form_titulo').html('Adicionar');
                $('#btnEnviaFormJogadores').removeClass('btn-light');
                $('#btnEnviaFormJogadores').addClass('btn-dark');
                $('#btnCancelaFormJogadores').addClass('d-none');

                carregaSelectJogadores();
                $('#selectJogadores').select2({ width: '100%' });
            }

            jQuery('#formJogadores').submit(function(e){
                carregando();
                e.preventDefault();
                var fd = new FormData(jQuery(this)[0]);

                jQuery.ajax({
                    url : '{{url('/cadastra-jogador')}}',
                    type : 'POST',
                    contentType : false,
                    data : fd,
                    processData : false,
                    success : function(data) {
                        if(data == 1){
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Jogador registrado!',
                                showConfirmButton: false,
                                timerProgressBar: true,
                                timer: 2000
                            });
                            concluiJogadores();
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Ops, algum erro ocorreu!',
                                showConfirmButton: false,
                                timerProgressBar: true,
                                timer: 2000
                            })
                        }
                    }
                });
            });

            jQuery('#formSorteio').submit(function(e){
                carregando();
                e.preventDefault();
                var fd = new FormData(jQuery(this)[0]);

                jQuery.ajax({
                    url : '{{url('/realiza-sorteio')}}',
                    type : 'POST',
                    contentType : false,
                    data : fd,
                    processData : false,
                    success : function(data) {
                        //STATUS 1=ERROR
                        if(data.status == 1){
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: data.errorTitle,
                                showConfirmButton: false,
                                timerProgressBar: true,
                                timer: 7000
                            });
                        } else {
                            carregou();
                        }

                        $('#divTimes').html(data.html);
                    }
                });
            });

            function carregaTabelaJogadores() {
                $('#divListaJogadores').html(spinner);

                $.ajax({
                    url: '{{url('carregar-jogadores')}}',
                    method: 'post',
                    data: {"_token":token},
                    dataType: 'json',
                    success: function (data) {
                        $('#divListaJogadores').html(data.html);
                    }
                });
            }

            function editarJogador(id){
                carregando();

                $.ajax({
                    url: '{{url('carregar-jogador')}}',
                    method: 'post',
                    data: {"_token":token,"id":id},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);

                        $.each(data,function(index, value){
                            $('#'+index).val(value);
                        });

                        $('#editar_jogadores').val('S');
                        $('#jogadores_form_titulo').html('Editar');
                        $('#btnEnviaFormJogadores').removeClass('btn-dark');
                        $('#btnEnviaFormJogadores').addClass('btn-light');
                        $('#btnCancelaFormJogadores').removeClass('d-none');

                        carregou();
                    }
                });
            }

            function excluirJogador(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-light'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Tem certeza?',
                    text: "Você não será capaz de reverter!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Excluir',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '{{url('excluir-jogador')}}',
                            method: 'post',
                            data: {"_token":token,"id":id},
                            dataType: 'json',
                            success: function (data) {
                                concluiJogadores();
                            }
                        });

                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Jogador excluido!',
                            showConfirmButton: false,
                            timerProgressBar: true,
                            timer: 1500
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {

                    }
                })
            }

            function carregaSelectJogadores(id){
                $.ajax({
                    url: '{{url('carregar-jogadores-select')}}',
                    method: 'post',
                    data: {"_token":token},
                    dataType: 'json',
                    success: function (data) {
                        $('#selectJogadores').html(data.html);
                    }
                });
            }

            //GRAPH

            am4core.useTheme(am4themes_dataviz);
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartdiv", am4charts.PieChart);
            var series = chart.series.push(new am4charts.PieSeries());

            series.dataFields.value = "Quantidade";
            series.dataFields.category = "Niveis";

            chart.data = [{
                "Niveis": "Nível 1 (Péssimo)",
                "Quantidade": {{$jogadoresCtl->getQtdPlayersByLevel(1)}}
            }, {
                "Niveis": "Nível 2 (Ruim)",
                "Quantidade": {{$jogadoresCtl->getQtdPlayersByLevel(2)}}
            }, {
                "Niveis": "Nível 3 (Mediano)",
                "Quantidade": {{$jogadoresCtl->getQtdPlayersByLevel(3)}}
            }, {
                "Niveis": "Nível 4 (Bom)",
                "Quantidade": {{$jogadoresCtl->getQtdPlayersByLevel(4)}}
            }, {
                "Niveis": "Nível 5 (Excelente)",
                "Quantidade": {{$jogadoresCtl->getQtdPlayersByLevel(5)}}
            }];

            chart.legend = new am4charts.Legend();
        </script>
    </footer>
</html>
