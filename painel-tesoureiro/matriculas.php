<?php 
$pag = "matriculas";
require_once("../conexao.php"); 

@session_start();
$cpf_usuario = @$_SESSION['cpf_usuario'];
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'tesoureiro'){
  echo "<script language='javascript'> window.location='../index.php' </script>";

} 


?>



<!-- DataTales Example -->
<div class="card shadow mb-4">

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th >Nome do Aluno</th>
            <th class="classe-nova">Data de Nascimento</th>
            <th class="classe-nova ">Responsável</th>
            <th class="classe-nova classe-nova-tel">Telefone do Responsável</th>

            <th>Ações</th>
          </tr>
        </thead>

        <tbody>

         <?php 

         $query = $pdo->query("SELECT * FROM tbaluno order by IdAluno desc ");
         $res = $query->fetchAll(PDO::FETCH_ASSOC);


         for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $nome = $res[$i]['NomeAluno'];
          $foto = $res[$i]['foto'];


          $dataNascimento = date('d/m/Y',  strtotime($res[$i]['DataNascimento'])); 



          $id = $res[$i]['IdAluno'];
          $id_responsavel = $res[$i]['IdResponsavel'];

          $query = $pdo->query("SELECT * FROM tbresponsavel where IdResponsavel = '$id_responsavel' ");
          $res_r = $query->fetchAll(PDO::FETCH_ASSOC);

          $nome_responsavel = $res_r[0]['NomeResponsavel'];
          $celular = $res_r[0]['Celular'];




          ?>


          <tr>
            <td><a title="Ver Matrículas" class="text-dark" href="index.php?pag=<?php echo $pag ?>&funcao=matriculas&id=<?php echo $id ?>"><?php echo @$nome ?></a></td>
            <td class="classe-nova"><?php echo @$dataNascimento ?></td>
            <td class="classe-nova "><?php echo @$nome_responsavel ?></td>
            <td class="classe-nova classe-nova-tel"><?php echo $celular ?></td>




            <td>
              <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Dados do Aluno'><i class="fas fa-info-circle"></i></a>

              <a href="index.php?pag=<?php echo $pag ?>&funcao=turmas&id=<?php echo $id ?>" class='text-primary mr-1' title='Ver Turmas'><i class="fas fa-book-open"></i></a>    

            </td>
          </tr>
        <?php } ?>





      </tbody>
    </table>
  </div>
</div>
</div>


<!--MODAL PARA MOSTRAR DADOS COMPLETOS -->
<div class="modal" id="modal-endereco" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dados do Aluno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php 
        if (@$_GET['funcao'] == 'endereco') {

          $id2 = $_GET['id'];

          $query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id2' ");
          $res_3 = $query->fetchAll(PDO::FETCH_ASSOC);

          $nome3 = $res_3[0]['NomeAluno'];
          $data3 = $res_3[0]['DataNascimento'];
          $sexo3 = $res_3[0]['Sexo'];
          $mae3 = $res_3[0]['NomeMae'];
          $pai3 = $res_3[0]['NomePai'];
          $email3 = $res_3[0]['Email'];
          $telefone3 = $res_3[0]['Celular'];
          $cpf3 = $res_3[0]['CPF'];
          $rg3 = $res_3[0]['RG'];
          $registro3 = $res_3[0]['RegistroNascimentoNumero'];
          $cartorio3 = $res_3[0]['RegistroNascimentoCartorio'];
          $livro3 = $res_3[0]['RegistroNascimentoLivro'];
          $folha3 = $res_3[0]['RegistroNascimentoFolha'];
          $dataRegistro3 = $res_3[0]['RegistroNascimentoData'];
          $foto3 = $res[0]['foto'];
          $naturalidade3 = $res_3[0]['NaturalidadeCidade'];
          $nacionalidade3 = $res_3[0]['Nacionalidade'];
          $naturalidadeUF3 = $res_3[0]['NaturalidadeUF'];
          $id_responsavel3 = $res_3[0]['IdResponsavel'];
          $id_endereco3 = $res_3[0]['IdEndereco'];
          $imagem3 = $res_3[0]['foto']; 

          $query = $pdo->query("SELECT * FROM tbresponsavel where IdResponsavel = '$id_responsavel3' ");
          $res_r3 = $query->fetchAll(PDO::FETCH_ASSOC);

          $cpf_responsavel3 = $res_r3[0]['CPFCNPJ'];
          $nome_responsavel3 = $res_r3[0]['NomeResponsavel'];
          $telefone_responsavel3 = $res_r3[0]['Celular'];

          $query = $pdo->query("SELECT * FROM tbendereco where IdEndereco = '$id_endereco3' ");
          $res_end = $query->fetchAll(PDO::FETCH_ASSOC);

          $logradouro3 = $res_end[0]['Logradouro'];
          $complemento3 = $res_end[0]['Complemento'];
          $bairro3 = $res_end[0]['Bairro'];
          $cidade3 = $res_end[0]['Cidade'];
          $uf_endereco3 = $res_end[0]['UF'];
          $cep3 = $res_end[0]['CEP'];

        } 


        ?>

        <div class="row">
          <div class="col-md-8">
           <div class="row">
            <div class="form-group col-md-6">
              <label >Nome do Aluno</label>
              <input onkeyup="maiuscula(this)" disabled value="<?php echo @$nome3 ?>" type="text" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label >Data de Nascimento</label>
              <input disabled value="<?php echo @$data3 ?>" type="date" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label >Sexo</label>
              <input class="form-control" disabled value="<?php echo @$sexo3 ?>" />


            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label >Mãe</label>
              <input disabled value="<?php echo @$mae3 ?>" type="text" class="form-control">
            </div>
            <div class="form-group col-md-6">
              <label >Pai</label>
              <input disabled  value="<?php echo @$pai3 ?>" type="text" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label >Email</label>
              <input disabled value="<?php echo @$email3 ?>" type="text" class="form-control" >
            </div>
            <div class="form-group col-md-6">
              <label >Telefone</label>
              <input disabled value="<?php echo @$telefone3 ?>" type="text" class="form-control">
            </div>
          </div>


          <div class="row">

            <div class="form-group col-md-6 ">
              <label for="cpf-cat" >CPF</label>
              <input disabled value="<?php echo @$cpf3 ?>" type="text" class="form-control" >
            </div>
            <div class="form-group col-md-6 ">
              <label >RG</label>
              <input disabled value="<?php echo @$rg3 ?>" type="text" class="form-control">
            </div>

          </div>
          <div class="row">
            <div class="form-group col-md-6 ">
              <label >Nome do Responsável</label>
              <input disabled value="<?php echo @$nome_responsavel3 ?>" type="text" class="form-control"  >


            </div>
            <div class="form-group col-md-3 ">
              <label >CPF do Responsável</label>
              <input disabled value="<?php echo @$cpf_responsavel3 ?>" type="text" class="form-control"  >
            </div>
            <div class="form-group col-md-3 ">
              <label >Tel. do Responsável</label>
              <input disabled value="<?php echo @$telefone_responsavel3 ?>" type="text" class="form-control"  >
            </div>
          </div>
          <div class="row">

            <div class="form-group col-md-3 ">
              <label >Número do Registro</label>
              <input value="<?php echo @$registro3 ?>" disabled type="text" class="form-control" >
            </div>
            <div class="form-group col-md-2 ">
              <label >Cartório</label>
              <input disabled value="<?php echo @$cartorio3 ?>" type="text" class="form-control" >
            </div>
            <div class="form-group col-md-2 ">
              <label >Livro</label>
              <input disabled value="<?php echo @$livro3 ?>" type="text" class="form-control" >
            </div>
            <div class="form-group col-md-2 ">
              <label >Folha</label>
              <input disabled value="<?php echo @$folha3 ?>" type="text" class="form-control" id="folha-cat" name="folha-cat" placeholder="Folha">
            </div>
            <div class="form-group col-md-3 ">
              <label >Data de Registro</label>
              <input disabled value="<?php echo @$dataRegistro3 ?>" type="date" class="form-control" >
            </div>

          </div>
          <div class="row">
            <div class="form-group col-md-3 ">
              <label >Cidade Natural</label>
              <input disabled  value="<?php echo @$naturalidade3 ?>" type="text" class="form-control">
            </div>
            <div class="form-group col-md-3 ">
              <label >UF Natural</label>
              <select class="form-control" disabled value="<?php echo @$naturalidadeUF3 ?>"  >

                <option value="<?php echo @$naturalidadeUF3 ?>"><?php echo @$naturalidadeUF3 ?></option>';


              </select>
            </div>
            <div class="form-group col-md-3 ">
              <label >Nacionalidade</label>
              <input disabled value="<?php echo @$nacionalidade3 ?>" type="text" class="form-control" >
            </div>

            <div class="container"><div class="row d-flex justify-content-center mb-3"><strong>Endereço</strong></div></div>
            <div class="row ml-1">

              <div class="form-group col-md-4 ">
                <label for="cpf-cat" >Logradouro</label>
                <input  disabled value="<?php echo $logradouro3 ?>" type="text" class="form-control">
              </div>
              <div class="form-group col-md-4 ">
                <label >Complemento</label>
                <input disabled  value="<?php echo @$complemento3 ?>" type="text" class="form-control" >
              </div>
              <div class="form-group col-md-4 ">
                <label >Bairro</label>
                <input disabled value="<?php echo @$bairro3 ?>" type="text" class="form-control" >
              </div>


            </div>
            <div class="row ml-1">
              <div class="form-group col-md-5 ">
                <label >Cidade</label>
                <input disabled value="<?php echo @$cidade3 ?>" type="text" class="form-control" >
              </div>
              <div class="form-group col-md-2 ">
                <label >UF</label>
                <select class="form-control" disabled value="<?php echo @$uf_endereco3 ?>"   >


                  <option value=""><?php echo @$uf_endereco3 ?></option>';



                </select>
              </div>
              <div class="form-group col-md-5 ">
                <label >CEP</label>
                <input value="<?php echo @$cep3 ?>" type="text" class="form-control"  disabled >
              </div>


            </div>
          </div>





        </div>
        <div class="col-md-4 p-0 mt-3 mb-3 d-flex justify-content-center align-items-center">

          <div id="divImgConta" >

            <img class="rounded mx-auto d-block align-content-center img-fluid" src="../img/alunos/<?php echo $imagem3 ?>" width="150" height="150" id="target">     

          </div>

        </div>

      </div>


    </div>
  </div>
</div>
</div>

<!--MODAL MOSTRAR MATRICULAS -->
<div class="modal" id="modal-matriculas" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Matrículas do Aluno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php 
        $query = $pdo->query("SELECT * FROM matriculas where aluno = '$_GET[id]' order by id desc ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $aluno = $res[$i]['aluno'];
          $turma = $res[$i]['turma'];
          $data = $res[$i]['data'];
          $dataF = implode('/', array_reverse(explode('-', $data)));
          $id_m = $res[$i]['id'];

          $query_r1 = $pdo->query("SELECT * FROM turmas where id = '".$turma."' ");
          $res_r1 = $query_r1->fetchAll(PDO::FETCH_ASSOC);

          $id_disciplina = $res_r1[0]['disciplina'];

          $query_r2 = $pdo->query("SELECT * FROM disciplinas where id = '".$id_disciplina."' ");
          $res_r2 = $query_r2->fetchAll(PDO::FETCH_ASSOC);

          $nome_disciplina = $res_r2[0]['nome'];


          ?>


          <span><?php echo @$nome_disciplina ?>

          <a target="_blank" title="Gerar Contrato" href="../rel/contrato_matricula.php?id=<?php echo $id_m ?>"><i class="far fa-clipboard text-primary ml-3"></i></span></a>

          <a target="_blank" title="Gerar Declaração Matrícula" href="../rel/declaracao_matricula.php?id=<?php echo $id_m ?>"><i class="far fa-clipboard text-secondary ml-2"></i></a>

          <hr style="margin: 4px">

        <?php } ?>



      </div>

    </div>
  </div>
</div>

<!--MODAL MOSTRAR Turmas -->
<div class="modal" id="modal-turmas" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Turmas do Aluno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

       <?php 
       if (@$_GET['funcao'] == 'turmas') {

        $id2 = $_GET['id'];

        $query = $pdo->query("SELECT * FROM matriculas where aluno = '$id2' ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);


        for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $id_turma = $res[$i]['turma'];
          $id_mat = $res[$i]['id'];


          $query_2 = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
          $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
          $disciplina = $res_2[0]['disciplina'];
          $horario = $res_2[0]['horario'];
          $dia = $res_2[0]['dia'];
          $ano = $res_2[0]['ano'];


          $query_resp = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
          $res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);

          $nome_disc = $res_resp[0]['nome'];


                  //VERIFICAR SE EXISTE ATRASO NO PAGAMENTO DAS MATRICULAS
          $query_3 = $pdo->query("SELECT * FROM pgto_matriculas where matricula = '$id_mat' ");
          $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);


          for ($i2=0; $i2 < count($res_3); $i2++) { 
            foreach ($res_3[$i2] as $key => $value) {
            }

            $data_venc = $res_3[$i2]['data_vencimento'];
            $pago = $res_3[$i2]['pago'];

            if($data_venc < date('Y-m-d') and $pago != 'Sim'){
              $atrasado = 'Sim';
            }




          }

          ?>


          <span><small>
           <?php if($atrasado == 'Sim'){ ?>
             <a class="text-danger" href="index.php?pag=<?php echo $pag ?>&funcao=pagamentos&id=<?php echo $id_mat ?>"><i><?php echo $nome_disc; 
             $atrasado = 'Não';
             ?></i>
           <?php }else{ ?>
             <a class="text-dark" href="index.php?pag=<?php echo $pag ?>&funcao=pagamentos&id=<?php echo $id_mat ?>"><i><?php echo $nome_disc ?></i>
             <?php } ?>
             - 
             <?php echo $dia ?> 
             <?php echo $horario ?> </a>
             <br></small></span>
             <hr style="margin:5px">


           <?php  } } ?>




         </div>

       </div>
     </div>
   </div>


   <div class="modal" id="modal-pagamentos" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <?php 
          $id_m = $_GET['id'];
          $query = $pdo->query("SELECT * FROM matriculas where id = '$id_m' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          $id = $res[0]['aluno'];
          $id_turma = $res[0]['turma'];

          $query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          $nome_aluno = $res[0]['NomeAluno'];
          $id_responsavel = $res[0]['IdResponsavel'];

          $query = $pdo->query("SELECT * FROM tbresponsavel where IdResponsavel = '$id_responsavel' ");
                      $res_r = $query->fetchAll(PDO::FETCH_ASSOC);

                      $nome_responsavel = $res_r[0]['NomeResponsavel'];
                      $celular = $res_r[0]['Celular'];

          $query = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          $disciplina = $res[0]['disciplina'];

          $query = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          $nome_disciplina = $res[0]['nome'];
          ?>
          <h6 class="modal-title"><?php echo @$nome_disciplina ?> - <?php echo @$nome_aluno ?></h6>
          <a type="button" class="close" href="index.php?pag=<?php echo $pag ?>&funcao=turmas&id=<?php echo $id ?>" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>

        </div>
        <div class="modal-body">

         <small>
           <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Parcela</th>
                <th scope="col">Vencimento</th>
                <th scope="col">Valor</th>
                <th scope="col">Pago</th>
                <th scope="col">Ações</th>

              </tr>
            </thead>
            <tbody>

              <?php 
              if (@$_GET['funcao'] == 'pagamentos') {

                $id2 = $_GET['id'];



                  //VERIFICAR SE EXISTE ATRASO NO PAGAMENTO DAS MATRICULAS
                $query_3 = $pdo->query("SELECT * FROM pgto_matriculas where matricula = '$id2' ");
                $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);


                for ($i2=0; $i2 < count($res_3); $i2++) { 
                  foreach ($res_3[$i2] as $key => $value) {
                  }

                  $data_venc = $res_3[$i2]['data_vencimento'];
                  $pago = $res_3[$i2]['pago'];
                  $valor = $res_3[$i2]['valor'];
                  $id_pgto = $res_3[$i2]['id'];
                  $arquivo = $res_3[$i2]['arquivo'];

                  if($data_venc < date('Y-m-d') and $pago != 'Sim'){
                    $atrasado = 'Sim';
                  }

                  $valor = number_format($valor, 2, ',', '.');
                  $data_venc_F = implode('/', array_reverse(explode('-', $data_venc)));

                  
                  


                  ?>

                  <tr>
                    <td scope="row"><?php echo $i2+1 ?></td>

                    <td>
                     <?php if($atrasado == 'Sim'){ ?>
                       <span class="text-danger"><?php echo $data_venc; 
                       $atrasado = 'Não';
                       ?></span>
                     <?php }else{ ?>
                      <span class="text-dark"> <?php echo $data_venc_F ?></span>
                    <?php } ?>
                  </td>

                  <td> R$ <?php echo $valor ?> </td>

                  <td>
                   <?php if($pago == 'Sim'){ ?>
                    <span class="text-success"> <?php echo $pago ?></span>
                  <?php }else{ ?>
                    <span class="text-danger"><?php echo $pago ?></span>
                  <?php } ?>
                </td>

                <td>

                 <?php if($pago == 'Sim'){ ?>
                  <a href="index.php?pag=<?php echo $pag ?>&funcao=baixa&id=<?php echo $id_pgto ?>" class='text-success ml-2' title='Baixa no Pagamento'><i class='fas fa-check'></i></a>
                  <?php 

                }else{ 
                  ?>
                  <a href="index.php?pag=<?php echo $pag ?>&funcao=baixa&id=<?php echo $id_pgto ?>" class='text-danger ml-2' title='Baixa no Pagamento'><i class='fas fa-check'></i></a>
                <?php } ?>



                <?php if($pgto_boleto == 'Sim'){ ?>
                  <a href="index.php?pag=<?php echo $pag ?>&funcao=upload&id=<?php echo $id_pgto ?>&id_m=<?php echo $id2 ?>" class='text-primary ml-2' title='Carregar Boleto / Carnê'><i class='fas fa-paperclip'></i></a>

                  <?php if($arquivo != ''){ ?>
                   <a href="../img/arquivos/<?php echo $arquivo ?>" class="text-dark ml-2" target="_blank" title="Abrir o Boleto / Carnê">Ver Arquivo</a>   
                 <?php } } ?>
               </td>

             </tr>



           <?php  } } ?>

         </tbody>
       </table>
     </small>

   </div>

 </div>
</div>
</div>





<?php 


if (@$_GET["funcao"] != null && @$_GET["funcao"] == "endereco") {
  echo "<script>$('#modal-endereco').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "matriculas") {
  echo "<script>$('#modal-matriculas').modal('show');</script>";
}
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "turmas") {
  echo "<script>$('#modal-turmas').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "pagamentos") {
  echo "<script>$('#modal-pagamentos').modal('show');</script>";
}

if (@$_GET["funcao"] != null && @$_GET["funcao"] == "baixa") {

    $id_pgto = $_GET['id'];

    require_once("baixar-mensalidade.php"); 

    echo "<script>window.location='index.php?pag=$pag&id=$id_mat&funcao=pagamentos';</script>";
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

<script>
  function maiuscula(string){
    res = string.value.toUpperCase();

    string.value=res;
  }
</script>



