<?php 
$pag = "gradecurricular";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'Admin'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

}

$query = $pdo->query("SELECT * FROM tbperiodo order by IdPeriodo desc limit 1 ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$id_periodo_renovar = $res[0]['IdPeriodo'];

$query = $pdo->query("SELECT * FROM tbgradecurricular order by IdPeriodo desc limit 1 ");
$res2 = $query->fetchAll(PDO::FETCH_ASSOC);

$id_periodo_antigo = $res2[0]['IdPeriodo'];



?>

<div class="row mt-4 mb-4">
    <a type="button" title="Cadastrar Nova Grade Curricular" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=novagradecurricular">Nova Grade Curricular</a>
    <a type="button" title="Renovar Grade Curricular" class="btn-success btn-sm ml-3 d-none d-md-block" href="index.php?pag=gradecurricular&funcao=renovar&id_periodo=<?php echo $id_periodo_renovar ?>&id_periodo_antigo=<?php echo $id_periodo_antigo ?>">Renovar Grade Curricular</a>
    <a type="button" title="Cadastrar Nova Grade Curricular" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i class="fas fa-user-plus"></i></a>
    
    
</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr class="bg-primary text-white">
                        <th >Ano</th>
                        
                        
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <tbody>

                 <?php 

                 $query = $pdo->query("SELECT * FROM tbperiodo order by IdPeriodo desc ");
                 $res = $query->fetchAll(PDO::FETCH_ASSOC);

                 for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                  $sigla_ano = $res[$i]['SiglaPeriodo'];




                  $id = $res[$i]['IdPeriodo'];


                  ?>


                  <tr class="table-light">
                    <td ><a title="Ver Séries" class="text-dark" href="index.php?pag=<?php echo $pag ?>&funcao=series&disciplinas=sim&id=<?php echo $id ?>"><?php echo $sigla_ano ?></a></td>


                    <td class="text-center">

                        <a href="index.php?pag=<?php echo $pag ?>&funcao=series&excluir=sim&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>
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

                    $query = $pdo->query("SELECT * FROM tbperiodo where IdPeriodo = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $idperiodo = $res[0]['IdPeriodo'];
                    $SiglaPeriodo = $res[0]['SiglaPeriodo'];
                    


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
                        <label >Ano Letivo</label>
                        <select name="ano_letivo" class="form-control" id="ano_letivo">


                            <?php 

                            $query = $pdo->query("SELECT * FROM tbperiodo order by IdPeriodo desc ");
                            $res = $query->fetchAll(PDO::FETCH_ASSOC);

                            for ($i=0; $i < @count($res); $i++) { 
                                foreach ($res[$i] as $key => $value) {
                                }
                                $nome_reg = $res[$i]['SiglaPeriodo'];
                                $id_reg = $res[$i]['IdPeriodo'];
                                ?>                                  
                                <option  value="<?php echo $id_reg ?>"><?php echo $nome_reg ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label >Série</label>
                        <select name="serie" class="form-control" id="serie">

                            <?php 

                            $query = $pdo->query("SELECT * FROM tbserie order by NomeSerie asc ");
                            $res1 = $query->fetchAll(PDO::FETCH_ASSOC);

                            for ($i=0; $i < @count($res1); $i++) { 
                                foreach ($res1[$i] as $key => $value) {
                                }
                                $nome_reg2 = $res1[$i]['NomeSerie'];
                                $id_reg2 = $res1[$i]['IdSerie'];
                                ?>                                  
                                <option  value="<?php echo $id_reg2 ?>"><?php echo $nome_reg2 ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <label >Selecione as Disciplinas</label><br>
                    
                    <div class="form-group">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Disciplina</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php  
                                $query = $pdo->query("SELECT * FROM tbdisciplina order by NomeDisciplina asc ");
                                $res2 = $query->fetchAll(PDO::FETCH_ASSOC);


                                for ($i=0; $i < @count($res2); $i++) { 
                                    foreach ($res2[$i] as $key => $value) {
                                    }
                                    $nome_reg3 = $res2[$i]['NomeDisciplina'];
                                    $id_reg3 = $res2[$i]['IdDisciplina'];


                                    ?>


                                    <tr>
                                        <td class="text-center"><input value="<?php echo @$id_reg3 ?>" name="id_disci[]" type="checkbox" ></td>
                                        <td name=""><?php echo $nome_reg3 ?></td>

                                    </tr>



                                <?php } ?>
                            </tbody>
                        </table>

                        <hr>
                    </div>





                    <small>
                        <div id="mensagem">

                        </div>
                    </small> 

                </div>



                <div class="modal-footer">



                    <input value="<?php echo @$_GET['id'] ?>" type="hidden" name="txtid2" id="txtid2">
                    <input value="<?php echo @$curso2 ?>" type="hidden" name="antigo" id="antigo">


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

                <p>Deseja realmente excluir a grade curricular dessa série?</p>

                <div align="center" id="mensagem_excluir" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-excluir">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id"  name="id" value="<?php echo @$_GET['id'] ?>" >
                    <input type="hidden" id="id_serie"  name="id_serie" value="<?php echo @$_GET['id_serie'] ?>" >

                    <button type="button" id="btn-deletar" name="btn-deletar" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-renovar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Renovar Grade Curricular</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja renovar toda a grade curricular para o ano letivo?</p>

                <div align="center" id="mensagem_renovar" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar1">Não</button>
                <form method="post">
                    <input type="hidden" id="id_periodoRenovar"  name="id_periodoRenovar" value="<?php echo @$_GET['id_periodo'] ?>">
                    <input type="hidden" id="id_periodoRenovar_antigo"  name="id_periodoRenovar_antigo" value="<?php echo @$_GET['id_periodo_antigo'] ?>">

                    <button type="button" id="btn-renovar" name="btn-renovar" class="btn btn-primary">Sim</button>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="modal" id="modal-endereco" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php 
                if (@$_GET['funcao'] == 'endereco') {

                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM tbcurso where IdCurso = '$id2' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    $curso3 = $res[0]['NomeCurso'];
                    $portaria3 = $res[0]['PortariaAutorizacao'];
                    $descricao3 = $res[0]['descricao'];

                    
                    
                } 


                ?>

                <div class="form-group">
                    <label >Curso</label>
                    <input disabled value="<?php echo @$curso3 ?>" type="text" class="form-control" >
                </div>
                <div class="form-group">
                    <label >Descrição</label>
                    <input disabled value="<?php echo @$descricao3 ?>" type="text" class="form-control" >
                </div>
                <div class="form-group">
                    <label >Portaria</label>
                    <input disabled value="<?php echo @$portaria3 ?>" type="text" class="form-control">
                </div>


            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-series" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Séries por ano</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">



                <?php 

                $id_ano = $_GET['id'];

                  //VERIFICAR SERIES

                        //VERIFICAR Disciplinas
                $query_4 = $pdo->query("SELECT DISTINCT IdSerie FROM tbgradecurricular where IdPeriodo = '$id_ano'");
                $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);

                $contador = count($res_4);
                for ($i=0; $i < count($res_4); $i++) { 
                  foreach ($res_4[$i] as $key => $value) {
                  }


                  $id_serie = $res_4[$i]['IdSerie'];



                  $query_3 = $pdo->query("SELECT * FROM tbserie where IdSerie = '$id_serie' order by NomeSerie");
                  $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);



                  $serie = $res_3[0]['NomeSerie'];


                  ?>

                  

                  <?php if(@$_GET['disciplinas'] != ""){ ?>
                      <a title="Ver disciplinas por série" href="index.php?pag=gradecurricular&funcao=disciplinas&id=<?php echo $id_ano ?>&id_serie=<?php echo $id_serie ?>" name="btn-ver-disciplinas" class="btn btn-primary text-light m-1"><?php echo $serie ?></a>
                  <?php } ?>
                  <?php if(@$_GET['excluir'] != ""){ ?>
                      <a title="Excluir" href="index.php?pag=gradecurricular&funcao=excluir&id=<?php echo $id_ano ?>&id_serie=<?php echo $id_serie ?>" name="btn-excluir-grade" class="btn btn-primary text-light m-1"><?php echo $serie ?></a>
                  <?php } ?>





              <?php  }  ?>

              <?php if ($contador == 0){ ?>
                <small> <span class="text-danger">Ainda não existem séries e disciplinas cadastradas para esse ano letivo. Por favor cadastre clicando 'Cadastrar' ou renove a grade curricular automaticamente em 'Renovar'</span></small>
            <?php } ?>



        </div>
        <?php if ($contador == 0){ ?>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" href="#" class="btn btn-secondary">Fechar</button>



            <a title="Cadastrar Nova Grade Curricular" type="button" href="index.php?pag=novagradecurricular"  class="btn btn-primary">Cadastrar</a>

            <a type="button" title="Renovar Grade Curricular" class="btn btn-success " href="index.php?pag=gradecurricular&funcao=renovar&id_periodo=<?php echo $id_periodo_renovar ?>&id_periodo_antigo=<?php echo $id_periodo_antigo ?>">Renovar</a>
        <?php } ?>
    </div>
</div>
</div>
</div>

<div class="modal" id="modal-disciplinas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Disciplinas por Série</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <?php 

                $id_ano = $_GET['id'];
                $id_serie = $_GET['id_serie'];

                
                $query_4 = $pdo->query("SELECT * FROM tbgradecurricular where IdPeriodo = '$id_ano' and IdSerie = '$id_serie'");
                $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);
                for ($i=0; $i < count($res_4); $i++) { 
                  foreach ($res_4[$i] as $key => $value) {
                  }

                  $id_disciplina = $res_4[$i]['IdDisciplina'];



                  $query_3 = $pdo->query("SELECT * FROM tbdisciplina where IdDisciplina = '$id_disciplina'");
                  $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);



                  $disciplina = $res_3[0]['NomeDisciplina'];


                  ?>



                  <a title="Ver disciplinas por série"  name="btn-salvar-aula" class="btn btn-primary text-light m-1"><?php echo $disciplina ?></a><br>



              <?php  }  ?>



          </div>
          <div class="modal-footer">
            <a type="button" href="index.php?pag=gradecurricular&funcao=series&disciplinas=sim&id=<?php echo $id_ano ?>" class="btn btn-secondary">Voltar</a>



            <button type="button" data-dismiss="modal" class="btn btn-danger">Fechar</button>
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
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "series") {
    echo "<script>$('#modal-series').modal('show');</script>";
}
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "disciplinas") {
    echo "<script>$('#modal-disciplinas').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "renovar") {
    echo "<script>$('#modal-renovar').modal('show');</script>";
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
                    //$('#btn-fechar').click();
                    //window.location = "index.php?pag="+pag;

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

<!--AJAX PARA RENOVAR GRADE CURRICULAR -->

<script type="text/javascript">
    $(document).ready(function () {
        var pag = "<?=$pag?>";
        $('#btn-renovar').click(function (event) {
            event.preventDefault();

            $.ajax({
                url: pag + "/renovar.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (mensagem) {

                    $('#mensagem_renovar').addClass('')

                    if (mensagem.trim() === 'Renovado com Sucesso!!') {


                        $('#btn-cancelar1').click();
                        window.location = "index.php?pag=" + pag;
                    }else{

                        $('#mensagem_renovar').addClass('text-danger')
                        $('#mensagem_renovar').text(mensagem)

                    }




                },

            })
        })
    })
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



