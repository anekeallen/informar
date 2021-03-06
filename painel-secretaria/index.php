<?php 
@session_start();
require_once("../conexao.php");

//RECUPERAR DADOS USUARIO
if(@isset($_SESSION['id_usuario'])){
    $query = $pdo->query("SELECT * FROM usuarios where id = '$_SESSION[id_usuario]'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);

}

$nome_usu = @$res[0]['nome'];
$login_usu = @$res[0]['email'];
$senha_usu = @$res[0]['senha'];
$cpf_usu = @$res[0]['cpf'];
$id_usu = @$res[0]['id'];


    //variaveis para o menu
 //variaveis para o menu
$pag = @$_GET["pag"];
$menu1 = "alunos";
$menu2 = "responsaveis";
$menu3 = "turmas";
$menu4 = "atas_matriculas";
$menu5 = "";
$menu6 = "";
$menu7 = "";


?>



<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="DevAllen">

    <title>Painel Secretaria</title>

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
    <link rel="icon" href="../img/favicon0.ico" type="image/x-icon">

</head> 

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">

                <div class="sidebar-brand-text mx-3">Secretaria</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">



            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Cadastros
            </div>



            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="index.php?pag=<?php echo $menu1 ?>">
                    <i class="fas fa-address-card"></i>
                    <span>Alunos</span></a>
                </li>

                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pag=<?php echo $menu2 ?>">
                        <i class="fas fa-address-book"></i>
                        <span>Responsáveis </span></a>
                    </li>

                    <!-- Nav Item - Charts -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?pag=<?php echo $menu3 ?>">
                            <i class="fas fa-bookmark"></i>
                            <span>Turmas</span></a>
                        </li>



                        <!-- Divider -->
                        <hr class="sidebar-divider d-none d-md-block">

                        <!-- Heading -->
                        <div class="sidebar-heading">
                            Relatórios
                        </div>


                        <!-- Nav Item - Charts -->
                        <li class="nav-item">
                            <a class="nav-link" href="" data-toggle="modal" data-target="#ModalAtaMatricula">
                                <i class="fas fa-book"></i>
                                <span>Livro de Matrículas</span></a>
                            </li>

                              <!-- Nav Item - Charts -->
                        <li class="nav-item">
                            <a class="nav-link" href="" data-toggle="modal" data-target="#ModalAtaResultados">
                                <i class="fas fa-book"></i>
                                <span>Atas de Resultados</span></a>
                            </li>

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
                                    <button id="sidebarToggleTop" class="btn btn-link d-lg-none rounded-circle mr-3">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                    <a href="index.php"> 
                                        <img class="mt-3 mb-2" src="../img/logo.png" width="190">
                                    </a>



                                    <!-- Topbar Navbar -->
                                    <ul class="navbar-nav ml-auto">




                                      <!-- Nav Item - User Information -->
                                      <li class="nav-item dropdown no-arrow">
                                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Editar dados">
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

                                } else if (@$pag==$menu7) {
                                    @include_once(@$menu7.".php");

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
                                    <span aria-hidden="true">x</span>
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
                                        <input required value="<?php echo $senha_usu ?>" type="password" class="form-control" id="senha_usu" name="senha_usu" placeholder="Senha">
                                    </div>





                                    <small>
                                        <div id="mensagem-perfil" class="mr-4">

                                        </div>
                                    </small>



                                </div>
                                <div class="modal-footer">



                                    <input value="<?php echo $id_usu ?>" type="hidden" name="id_usu" id="id_usu">
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

                            if (mensagem.trim() == "Salvo com Sucesso!!") {

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


            <!--  Modal Rel Pagar-->
            <div class="modal fade" id="ModalAtaMatricula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Livro de Matrículas</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <form action="../rel/livro_matricula.php" method="POST" target="_blank">
                            <div class="modal-body">

                               <div class="row">


                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label >Ano Letivo</label>
                                        <select name="ano_letivo" class="form-control" id="ano_letivo">

                                            <?php 

                                            $query = $pdo->query("SELECT * FROM tbperiodo order by IdPeriodo desc");
                                            $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                            for ($i=0; $i < @count($res); $i++) { 
                                                foreach ($res[$i] as $key => $value) {
                                                }
                                                $nome_reg = $res[$i]['SiglaPeriodo'];
                                                $id_reg = $res[$i]['IdPeriodo'];
                                                ?>                                  
                                                <option <?php if(@$categoria2 == $id_reg){ ?> selected <?php } ?> value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>


                                </div>

                            </div>     

                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">Gerar Livro</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>


            <!--  Modal Rel Pagar-->
            <div class="modal fade" id="ModalAtaResultados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Atas de Resultados</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <form action="../rel/atas_resultados.php" method="POST" target="_blank">
                            <div class="modal-body">

                               <div class="row">


                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label >Ano Letivo</label>
                                        <select name="ano_letivo" class="form-control" id="ano_letivo">

                                            <?php 

                                            $query = $pdo->query("SELECT * FROM tbperiodo order by IdPeriodo desc");
                                            $res = $query->fetchAll(PDO::FETCH_ASSOC);

                                            for ($i=0; $i < @count($res); $i++) { 
                                                foreach ($res[$i] as $key => $value) {
                                                }
                                                $nome_reg2 = $res[$i]['SiglaPeriodo'];
                                                $id_reg2 = $res[$i]['IdPeriodo'];
                                                ?>                                  
                                                <option <?php if(@$categoria2 == $id_reg2){ ?> selected <?php } ?> value="<?php echo $id_reg2 ?>"><?php echo $nome_reg2 ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>


                                </div>

                            </div>     

                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">Gerar Atas</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>