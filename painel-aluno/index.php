<?php 
@session_start();
require_once("../conexao.php"); 

    //variaveis para o menu
$pag = @$_GET["pag"];
$menu1 = "matriculas";
$menu2 = "mensalidades";
$menu3 = "pagar";
$menu4 = "funcionarios";
$menu5 = "disciplinas";
$menu6 = "salas";
$menu7 = "turmas";


    //RECUPERAR DADOS DO USUÁRIO
$query = $pdo->query("SELECT * FROM usuarios where id = '$_SESSION[id_usuario]'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = @$res[0]['nome'];
$cpf_usu = @$res[0]['cpf'];
$login_usu = @$res[0]['email'];
$idUsuario = @$res[0]['id'];
$senha_usu = @$res[0]['senha'];  

?>



<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Hugo Vasconcelos">

    <title>Painel Aluno</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="shortcut icon" href="../img/favicon0.ico" type="image/x-icon">
    <link rel="icon" href="../img/icone.ico" type="image/x-icon">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">

                <div class="sidebar-brand-text mx-3">Aluno</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">



            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                TURMAS EM ANDAMENTO
            </div>



            <?php 

            $query = $pdo->query("SELECT * FROM tbaluno where RegistroNascimentoNumero = '$cpf_usu' ");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $id_aluno = @$res[0]['IdAluno'];

            $antigo = 0;

            $query = $pdo->query("SELECT * FROM tbalunoturma where IdAluno = '$id_aluno'");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);


            for ($i=0; $i < count($res); $i++) { 
              foreach ($res[$i] as $key => $value) {
              }

              $id_turma = @$res[$i]['IdTurma'];
              


              $query_resp = $pdo->query("SELECT * FROM tbturma where IdTurma = '$id_turma' and datafinal >= curDate() ");
              $res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);
              
              $sigla_turma = @$res_resp[0]['SiglaTurma'];
              $nome_turma = @$res_resp[0]['NomeTurma'];
              $id_periodo = @$res_resp[0]['IdPeriodo'];

              $id_serie = @$res_resp[0]['IdSerie'];

              $query_serie = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie'");
              $res_serie = $query_serie->fetchAll(PDO::FETCH_ASSOC);

              $nome_serie = @$res_serie[0]['NomeSerie'];
              



              ?> 

              <?php if($nome_turma != "" and $id_turma != $antigo){ ?>

                  <!-- Nav Item - Charts -->
                  <li class="nav-item">
                    <a class="nav-link" href="index.php?pag=disciplinas&id=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>">
                        <i class="fab fa-leanpub"></i>
                        <span><?php echo $nome_serie ?> - <?php echo $nome_turma ?></span></a>
                    </li>

                    <!-- Nav Item - Tables -->


                    <!-- Divider -->
                    <hr class="sidebar-divider d-none d-md-block">

                <?php }

                $antigo = $id_turma; 
            } ?>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <img class="mt-2" src="../img/logo.png" width="150">



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">



                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nome_usu ?></span>
                                <img class="img-profile rounded-circle" src="../img/sem-foto.jpg">

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalPerfil">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-primary"></i>
                                    Editar Perfil
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php if (@$pag == null) { 
                        @include_once("home.php"); 
                        
                    } else if (@$pag==$menu1) {
                        @include_once(@$menu1.".php");
                        
                    } else if (@$pag==$menu2) {
                        @include_once(@$menu2.".php");

                    } else if (@$pag==$menu3) {
                        include_once(@$menu3.".php");

                    } else if (@$pag==$menu4) {
                        @include_once(@$menu4.".php");

                    } else if (@$pag==$menu5) {
                        @include_once(@$menu5.".php");

                    } else if (@$pag==$menu6) {
                        @include_once(@$menu6.".php");


                    } else if (@$pag=='turma') {
                        @include_once("turma.php");
                        
                    } else {
                        @include_once("home.php");
                    }
                    ?>



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>




    <!--  Modal Perfil-->
    <div class="modal fade" id="ModalPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>



                <form id="form-perfil" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">


                        <div class="form-group">
                            <label >Nome</label>
                            <input required value="<?php echo $nome_usu ?>" type="text" class="form-control" id="nome_usu" name="nome_usu" placeholder="Nome">
                        </div>


                        <div class="form-group">
                            <label >Login</label>
                            <input required value="<?php echo $login_usu ?>" type="text" class="form-control" id="login_usu" name="login_usu" placeholder="Login">
                        </div>

                        <div class="form-group">
                            <label >Senha</label>
                            <input required value="<?php echo $senha_usu ?>" value="" type="password" class="form-control" id="senha_usu" name="senha_usu" placeholder="Senha">
                        </div>




                        <small>
                            <div id="mensagem-perfil" class="mr-4">

                            </div>
                        </small>



                    </div>
                    <div class="modal-footer">



                        <input value="<?php echo $idUsuario ?>" type="hidden" name="id_usu" id="id_usu">
                        <input value="<?php echo $cpf_usu ?>" type="hidden" name="cpf_usu" id="cpf_usu">
                        <input value="<?php echo $login_usu ?>" type="hidden" name="antigo2_usu" id="antigo2_usu">



                        <button type="button" id="btn-fechar-perfil" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-salvar-perfil" id="btn-salvar-perfil" class="btn btn-primary">Salvar</button>
                    </div>
                </form>


            </div>
        </div>
    </div>


    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script src="../js/mascaras.js"></script>

</body>

</html>





<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form-perfil").submit(function () {

        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "editar-perfil.php",
            type: 'POST',
            data: formData,

            success: function (mensagem) {

                $('#mensagem-perfil').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar-perfil').click();
                    window.location = "index.php";

                } else {

                    $('#mensagem-perfil').addClass('text-danger')
                }

                $('#mensagem-perfil').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function () {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>



