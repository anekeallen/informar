<?php 
$pag = "salas";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

}


?>

<div class="row mt-4 mb-4">
    <a type="button" title="Cadastrar Nova Sala" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Nova Sala</a>
    <a type="button" title="Cadastrar Nova Sala" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i class="fas fa-user-plus"></i></a>
    
</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr class="bg-primary text-white">
                        <th >Sala</th>
                        <th >Descrição</th>
                        <th >Capacidade</th>
                        <th >Ações</th>
                    </tr>
                </thead>

                <tbody>

                   <?php 

                   $query = $pdo->query("SELECT * FROM salas order by id desc ");
                   $res = $query->fetchAll(PDO::FETCH_ASSOC);

                   for ($i=0; $i < count($res); $i++) { 
                      foreach ($res[$i] as $key => $value) {
                      }

                      $sala = $res[$i]['sala'];
                      $descricao = $res[$i]['descricao'];
                      $total_vagas = $res[$i]['total_vagas'];


                      $id = $res[$i]['id'];


                      ?>


                      <tr class="table-light">
                        <td><?php echo $sala ?></td>

                        <td><?php echo $descricao ?></td>
                        <td><?php echo $total_vagas ?></td>




                        <td>
                            <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Dados da Sala'><i class="fas fa-info-circle"></i></a>
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





<!-- Modal -->
<div class="modal fade" id="modalDados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if (@$_GET['funcao'] == 'editar') {
                    $titulo = "Editar Registro";
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM salas where id = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $sala2 = $res[0]['sala'];
                    $descricao2 = $res[0]['descricao'];
                    $total_vagas2 = $res[0]['total_vagas'];


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

                    <div class="form-group">
                        <label >Sala</label>
                        <input required value="<?php echo @$sala2 ?>" type="text" class="form-control" id="sala-cat" name="sala-cat" placeholder="Nome">
                    </div>
                    <div class="form-group">
                        <label >Descrição</label>
                        <input value="<?php echo @$descricao2 ?>" type="text" class="form-control" id="descricao-cat" name="descricao-cat" placeholder="Descrição">
                    </div>
                    <div class="form-group">
                        <label >Capacidade</label>
                        <input required value="<?php echo @$total_vagas2 ?>" type="number" class="form-control" id="total_vagas-cat" name="total_vagas-cat" placeholder="Capacidade da Sala">
                    </div>





                    <small>
                        <div id="mensagem">

                        </div>
                    </small> 

                </div>



                <div class="modal-footer">



                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo @$sala2 ?>" type="hidden" name="antigo" id="antigo">


                    <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>






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


<div class="modal" id="modal-endereco" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados da Sala</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php 
                if (@$_GET['funcao'] == 'endereco') {

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM salas where id = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $sala3 = $res[0]['sala'];
                    $descricao3 = $res[0]['descricao'];
                    $total_vagas3 = $res[0]['total_vagas'];
                    
                    
                } 


                ?>

                <div class="form-group">
                    <label >Sala</label>
                    <input disabled value="<?php echo @$sala3 ?>" type="text" class="form-control" id="sala-cat" name="sala-cat" placeholder="Nome">
                </div>
                <div class="form-group">
                    <label >Descrição</label>
                    <input disabled value="<?php echo @$descricao3 ?>" type="text" class="form-control" id="descricao-cat" name="descricao-cat" placeholder="Descrição">
                </div>
                <div class="form-group">
                    <label >Capacidade</label>
                    <input disabled value="<?php echo @$total_vagas3 ?>" type="text" class="form-control" id="total_vagas-cat" name="total_vagas-cat" placeholder="Capacidade da Sala">
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
                "ordering": false,
                "stateSave": true,
                "stateDuration": 60 * 60 * 24,
                "autoWidth": false
            })

        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

    <script src="../js/mascaras.js"></script>



