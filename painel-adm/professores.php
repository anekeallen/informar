<?php 
$pag = "professores";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

} 


?>

<div class="row mt-4 mb-4">
    <a type="button" title="Cadastrar Novo Professor" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Novo Professor</a>
    <a type="button" title="Cadastrar Novo Professor" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i class="fas fa-user-plus"></i></a>
    
</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th >Nome</th>
                        <th class="classe-nova">Email</th>
                        <th class="classe-nova ">Telefone</th>
                        <th class="classe-nova classe-nova-tel">CPF</th>
                        <th class="">Foto</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM professores order by id desc ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $nome = $res[$i]['nome'];
                  $email = $res[$i]['email'];
                  $telefone = $res[$i]['telefone'];
                  $cpf = $res[$i]['cpf'];
                  $endereco = $res[$i]['endereco'];
                  $foto = $res[$i]['foto'];


                  $id = $res[$i]['id'];


                  ?>


                  <tr>
                    <td><?php echo $nome ?></td>
                    <td class="classe-nova"><?php echo $email ?></td>
                    <td class="classe-nova "><?php echo $telefone ?></td>
                    <td class="classe-nova classe-nova-tel"><?php echo $cpf ?></td>
                    <td class="text-center"><a href="index.php?pag=<?php echo $pag ?>&funcao=foto&id=<?php echo $id ?>"><img width="50" src="../img/professores/<?php echo $foto ?>"><a></td>



                        <td>
                            <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Dados do Secretário'><i class="fas fa-info-circle"></i></a>

                            <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>

                            <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>
                        </td>
                    </tr>
                <?php } ?>





            </tbody>
        </table>
    </div>
</div>
</div>





<!-- Modal Mostrar Cadastrar dados-->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if (@$_GET['funcao'] == 'editar') {
                    $titulo = "Editar Registro";
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM professores where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome2 = $res[0]['nome'];
                    $email2 = $res[0]['email'];
                    $telefone2 = $res[0]['telefone'];
                    $endereco2 = $res[0]['endereco'];
                    $cpf2 = $res[0]['cpf'];
                    $foto2 = $res[0]['foto'];


                } else {
                    $titulo = "Inserir Registro";

                }


                ?>
                
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" method="POST">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                         <div class="form-group">
                            <label >Nome</label>
                            <input required value="<?php echo @$nome2 ?>" type="text" class="form-control" id="nome-cat" name="nome-cat" placeholder="Nome">
                        </div>
                        <div class="form-group">
                            <label >Email</label>
                            <input required value="<?php echo @$email2 ?>" type="text" class="form-control" id="email-cat" name="email-cat" placeholder="Email">
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <label >Telefone</label>
                                <input required value="<?php echo @$telefone2 ?>" type="text" class="form-control" id="telefone-cat" name="telefone-cat" placeholder="Telefone">
                            </div>
                            <div class="form-group col-6 ">
                                <label >CPF</label>
                                <input required value="<?php echo @$cpf2 ?>" type="text" class="form-control" id="cpf-cat" name="cpf-cat" placeholder="CPF">
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label >Endereço</label>
                            <input value="<?php echo @$endereco2 ?>" type="text" class="form-control" id="endereco-cat" name="endereco-cat" placeholder="Endereço">
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Imagem</label>
                            <input type="file" value="<?php echo @$foto2 ?>"  class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
                        </div>

                        <div id="divImgConta">
                            <?php if(@$foto2 != ""){ ?>
                                <img src="../img/professores/<?php echo $foto2 ?>" width="150" height="150" id="target">
                            <?php  }else{ ?>
                                <img src="../img/professores/sem-foto.jpg" width="150" height="150" id="target">
                            <?php } ?>
                        </div>

                    </div>

                </div>





                <small>
                    <div id="mensagem">

                    </div>
                </small> 

            </div>



            <div class="modal-footer">



                <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                <input value="<?php echo @$cpf2 ?>" type="hidden" name="antigo" id="antigo">
                <input value="<?php echo @$email2 ?>" type="hidden" name="antigo2" id="antigo2">

                <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
</div>





<!--MODAL PARA EXCLUIR REGISTRO -->
<div class="modal" id="modal-deletar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja realmente Excluir este Registro?</p>

                <div align="center" id="mensagem_excluir" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--MODAL PARA EXIBIR FOTO -->
<div class="modal" id="modal-foto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <?php 
                if (@$_GET['funcao'] == 'foto') {

                    $id_foto = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM professores where id = '$id_foto' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                    $imagem4 = $res[0]['foto'];  
                    
                } 


                ?>
                <div id="divImgConta" >

                    <img class="rounded mx-auto d-block align-content-center img-fluid" src="../img/professores/<?php echo $imagem4 ?>" width="300" height="300" id="target">     

                </div>

            </div>
            
        </div>
    </div>
</div>

<!--MODAL PARA MOSTRAR DADOS COMPLETOS -->
<div class="modal" id="modal-endereco" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Professor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php 
                if (@$_GET['funcao'] == 'endereco') {

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM professores where id = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $nome3 = $res[0]['nome'];
                    $cpf3 = $res[0]['cpf'];
                    $telefone3 = $res[0]['telefone'];
                    $email3 = $res[0]['email'];
                    $endereco3 = $res[0]['endereco'];
                    $imagem3 = $res[0]['foto'];  
                    
                } 


                ?>

                <div class="row">
                    <div class="col-md-7">
                     <div class="form-group">
                        <label >Nome</label>
                        <input disabled value="<?php echo @$nome3 ?>" type="text" class="form-control" id="nome-cat" name="nome-cat" placeholder="Nome">
                    </div>
                    <div class="form-group">
                        <label >Email</label>
                        <input disabled value="<?php echo @$email3 ?>" type="text" class="form-control" id="email-cat" name="email-cat" placeholder="Email">
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label >Telefone</label>
                            <input disabled value="<?php echo @$telefone3 ?>" type="text" class="form-control" id="telefone-cat" name="telefone-cat" placeholder="Telefone">
                        </div>
                        <div class="form-group col-6 ">
                            <label >CPF</label>
                            <input disabled value="<?php echo @$cpf3 ?>" type="text" class="form-control" id="cpf-cat" name="cpf-cat" placeholder="CPF">
                        </div>
                    </div>


                    <div class="form-group">
                        <label >Endereço</label>
                        <input disabled value="<?php echo @$endereco3 ?>" type="text" class="form-control" id="endereco-cat" name="endereco-cat" placeholder="Endereço">
                    </div>

                </div>

                <div class="col-md-5 p-0 mt-3 mb-3  d-flex justify-content-center align-items-center">

                    <div id="divImgConta" >

                        <img class="rounded mx-auto d-block align-content-center img-fluid" src="../img/professores/<?php echo $imagem3 ?>" width="250" height="250" id="target">     

                    </div>

                </div>

            </div>


        </div>




        <?php 

        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "novo") {
            echo "<script>$('#modalDados').modal('show');</script>";
        }

        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "editar") {
            echo "<script>$('#modalDados').modal('show');</script>";
        }

        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "excluir") {
            echo "<script>$('#modal-deletar').modal('show');</script>";
        }
        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "endereco") {
            echo "<script>$('#modal-endereco').modal('show');</script>";
        }
        if (@$_GET["funcao"] != null && @$_GET["funcao"] == "foto") {
            echo "<script>$('#modal-foto').modal('show');</script>";
        }

        ?>



        <!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
        <script type="text/javascript">
            $("#form").submit(function () {
                var pag = "<?=$pag?>";
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: pag + "/inserir.php",
                    type: 'POST',
                    data: formData,

                    success: function (mensagem) {

                        $('#mensagem').removeClass()

                        if (mensagem.trim() == "Salvo com Sucesso!!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar').click();
                    window.location = "index.php?pag="+pag;

                } else {

                    $('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)

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





        <!--AJAX PARA EXCLUSÃO DOS DADOS -->
        <script type="text/javascript">
            $(document).ready(function () {
                var pag = "<?=$pag?>";
                $('#btn-deletar').click(function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: pag + "/excluir.php",
                        method: "post",
                        data: $('form').serialize(),
                        dataType: "text",
                        success: function (mensagem) {

                            if (mensagem.trim() === 'Excluído com Sucesso!!') {


                                $('#btn-cancelar-excluir').click();
                                window.location = "index.php?pag=" + pag;
                            }

                            $('#mensagem_excluir').text(mensagem)



                        },

                    })
                })
            })
        </script>



        <!--SCRIPT PARA CARREGAR IMAGEM -->
        <script type="text/javascript">

            function carregarImg() {

                var target = document.getElementById('target');
                var file = document.querySelector("input[type=file]").files[0];
                var reader = new FileReader();

                reader.onloadend = function () {
                    target.src = reader.result;
                };

                if (file) {
                    reader.readAsDataURL(file);


                } else {
                    target.src = "";
                }
            }

        </script>





        <script type="text/javascript">
            $(document).ready(function () {
                $('#dataTable').dataTable({
                    "ordering": false
                })

            });
        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

        <script src="../js/mascaras.js"></script>



