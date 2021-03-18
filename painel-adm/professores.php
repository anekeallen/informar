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

                   $query = $pdo->query("SELECT * FROM tbprofessor order by IdProfessor desc ");
                   $res = $query->fetchAll(PDO::FETCH_ASSOC);

                   for ($i=0; $i < count($res); $i++) { 
                      foreach ($res[$i] as $key => $value) {
                      }

                      $nome = $res[$i]['NomeProfessor'];
                      $email = $res[$i]['Email'];
                      $telefone = $res[$i]['Celular'];
                      $cpf = $res[$i]['CPF'];
                      $id_endereco = $res[$i]['IdEndereco'];
                      $foto = $res[$i]['foto'];


                      $id = $res[$i]['IdProfessor'];


                      ?>


                      <tr>
                        <td><?php echo $nome ?></td>
                        <td class="classe-nova"><?php echo $email ?></td>
                        <td class="classe-nova "><?php echo $telefone ?></td>
                        <td class="classe-nova classe-nova-tel"><?php echo $cpf ?></td>
                        <td class="text-center"><a href="index.php?pag=<?php echo $pag ?>&funcao=foto&id=<?php echo $id ?>"><img width="50" src="../img/professores/<?php echo $foto ?>"><a></td>



                            <td>
                                <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Dados do Professor'><i class="fas fa-info-circle"></i></a>

                                <a href="index.php?pag=<?php echo $pag ?>&funcao=editar&id=<?php echo $id ?>" class='text-primary mr-1' title='Editar Dados'><i class='far fa-edit'></i></a>

                                <a href="index.php?pag=<?php echo $pag ?>&funcao=excluir&id=<?php echo $id ?>" class='text-danger mr-1' title='Excluir Registro'><i class='far fa-trash-alt'></i></a>

                                <a href="index.php?pag=<?php echo $pag ?>&funcao=disciplinas&id=<?php echo $id ?>" class='text-success mr-1' title='Cadastrar disciplinas ao Professor'><i class="fas fa-plus"></i></a>

                                <a href="index.php?pag=<?php echo $pag ?>&funcao=remover-disciplinas&id=<?php echo $id ?>" class='text-danger mr-1' title='Remover disciplinas do Professor'><i class="fas fa-minus-circle"></i></a>
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

                    $query = $pdo->query("SELECT * FROM tbprofessor where IdProfessor = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome2 = $res[0]['NomeProfessor'];
                    $email2 = $res[0]['Email'];
                    $telefone2 = $res[0]['Celular'];
                    $cpf2 = $res[0]['CPF'];
                    $id_endereco2 = $res[0]['IdEndereco'];
                    $foto2 = $res[0]['foto'];

                    $data2 = $res[0]['DataNascimento'];
                    $sexo2 = $res[0]['Sexo'];
                    $mae2 = $res[0]['NomeMae'];
                    $pai2 = $res[0]['NomePai'];
                    
                    $telefone2 = $res[0]['Celular'];
                    $telefone_fixo2 = $res[0]['Fone'];
                    $cpf2 = $res[0]['CPF'];
                    $rg2 = $res[0]['RG'];
                    $foto2 = $res[0]['foto'];
                    $naturalidade2 = $res[0]['NaturalidadeCidade'];
                    $nacionalidade2 = $res[0]['Nacionalidade'];
                    $naturalidadeUF2 = $res[0]['NaturalidadeUF'];
                    $id_endereco2  = $res[0]['IdEndereco'];
                    $rg_emissor2 = $res[0]['RG_OrgaoEmissor'];
                    $rg_data2 = $res[0]['RG_DataEmissao'];


                    $query = $pdo->query("SELECT * FROM tbendereco where IdEndereco = '" . $id_endereco2 . "' ");
                    $res_end = $query->fetchAll(PDO::FETCH_ASSOC);

                    $logradouro2 = $res_end[0]['Logradouro'];
                    $complemento2 = $res_end[0]['Complemento'];
                    $bairro2 = $res_end[0]['Bairro'];
                    $cidade2 = $res_end[0]['Cidade'];
                    $uf_endereco = $res_end[0]['UF'];
                    $cep2 = $res_end[0]['CEP'];

                    switch ($naturalidadeUF2) {
                       case 'AC':
                       $selectedAC = 'Selected';
                       break;
                       case 'AL':
                       $selectedAL = 'Selected';
                       break;
                       case 'AP':
                       $selectedAP = 'Selected';
                       break;
                       case 'AM':
                       $selectedAM = 'Selected';
                       break;
                       case 'BA':
                       $selectedBA = 'Selected';
                       break;
                       case 'CE':
                       $selectedCE = 'Selected';
                       break;
                       case 'DF':
                       $selectedDF = 'Selected';
                       break;
                       case 'ES':
                       $selectedES = 'Selected';
                       break;
                       case 'GO':
                       $selectedGO = 'Selected';
                       break;
                       case 'MA':
                       $selectedMA = 'Selected';
                       break;
                       case 'MT':
                       $selectedMT = 'Selected';
                       break;
                       case 'MS':
                       $selectedMS = 'Selected';
                       break;
                       case 'MG':
                       $selectedMG = 'Selected';
                       break;
                       case 'PA':
                       $selectedPA = 'Selected';
                       break;
                       case 'PB':
                       $selectedPB = 'Selected';
                       break;
                       case 'PR':
                       $selectedPR = 'Selected';
                       break;
                       case 'PE':
                       $selectedPE = 'Selected';
                       break;
                       case 'PI':
                       $selectedPI = 'Selected';
                       break;
                       case 'RJ':
                       $selectedRJ = 'Selected';
                       break;
                       case 'RN':
                       $selectedRN = 'Selected';
                       break;
                       case 'RS':
                       $selectedRS = 'Selected';
                       break;
                       case 'RO':
                       $selectedRO = 'Selected';
                       break;
                       case 'RR':
                       $selectedRR = 'Selected';
                       break;
                       case 'SC':
                       $selectedSC = 'Selected';
                       break;
                       case 'SP':
                       $selectedSP = 'Selected';
                       break;
                       case 'SE':
                       $selectedSE = 'Selected';
                       break;
                       case 'TO':
                       $selectedTO = 'Selected';
                       break;
                   }

                   switch ($uf_endereco) {
                       case 'AC':
                       $selectedAC_ = 'Selected';
                       break;
                       case 'AL':
                       $selectedAL_ = 'Selected';
                       break;
                       case 'AP':
                       $selectedAP_ = 'Selected';
                       break;
                       case 'AM':
                       $selectedAM_ = 'Selected';
                       break;
                       case 'BA':
                       $selectedBA_ = 'Selected';
                       break;
                       case 'CE':
                       $selectedCE_ = 'Selected';
                       break;
                       case 'DF':
                       $selectedDF_ = 'Selected';
                       break;
                       case 'ES':
                       $selectedES_ = 'Selected';
                       break;
                       case 'GO':
                       $selectedGO_ = 'Selected';
                       break;
                       case 'MA':
                       $selectedMA_ = 'Selected';
                       break;
                       case 'MT':
                       $selectedMT_ = 'Selected';
                       break;
                       case 'MS':
                       $selectedMS_ = 'Selected';
                       break;
                       case 'MG':
                       $selectedMG_ = 'Selected';
                       break;
                       case 'PA':
                       $selectedPA_ = 'Selected';
                       break;
                       case 'PB':
                       $selectedPB_ = 'Selected';
                       break;
                       case 'PR':
                       $selectedPR_ = 'Selected';
                       break;
                       case 'PE':
                       $selectedPE_ = 'Selected';
                       break;
                       case 'PI':
                       $selectedPI_ = 'Selected';
                       break;
                       case 'RJ':
                       $selectedRJ_ = 'Selected';
                       break;
                       case 'RN':
                       $selectedRN_ = 'Selected';
                       break;
                       case 'RS':
                       $selectedRS_ = 'Selected';
                       break;
                       case 'RO':
                       $selectedRO_ = 'Selected';
                       break;
                       case 'RR':
                       $selectedRR_ = 'Selected';
                       break;
                       case 'SC':
                       $selectedSC_ = 'Selected';
                       break;
                       case 'SP':
                       $selectedSP_ = 'Selected';
                       break;
                       case 'SE':
                       $selectedSE_ = 'Selected';
                       break;
                       case 'TO':
                       $selectedTO_ = 'Selected';
                       break;
                       default:
                       $selectedSEM_ = 'Selected';
                       break;

                   }



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
                    <div class="form-group col-md-6">
                      <label >Professor</label>
                      <input onkeyup="maiuscula(this)" required value="<?php echo @$nome2 ?>" type="text" class="form-control" id="nome-cat" name="nome-cat" placeholder="Nome do Professor">
                  </div>
                  <div class="form-group col-md-3">
                      <label >Data de Nascimento</label>
                      <input required value="<?php echo @$data2 ?>" type="date" class="form-control" id="data-cat" name="data-cat" placeholder="Data">
                  </div>
                  <div class="form-group col-md-3">
                      <label >Sexo</label>
                      <select class="form-control" required value="<?php echo @$sexo2 ?>" id="sexo-cat" name="sexo-cat">
                        <option <?php if (@$sexo2 =='M') {

                           ?> selected <?php } ?> value="M">Masculino</option>
                           <option <?php if (@$sexo2 =='F') {

                             ?> selected <?php } ?> value="F">Feminino</option>

                         </select>

                     </div>
                 </div>

                 <div class="row">


                    <div class="form-group col-md-4">
                        <label >Email</label>
                        <input required value="<?php echo @$email2 ?>" type="text" class="form-control" id="email-cat" name="email-cat" placeholder="Email">
                    </div>
                    <div class="form-group col-md-4">
                        <label >Celular</label>
                        <input value="<?php echo @$telefone2 ?>" required type="text" class="form-control" id="telefone-cat" name="telefone-cat" placeholder="Celular">
                    </div>
                    <div class="form-group col-md-4">
                        <label >Telefone Fixo</label>
                        <input value="<?php echo @$telefone_fixo2 ?>" type="text" class="form-control" id="telefone_fixo-cat" name="telefone_fixo-cat" placeholder="Telefone Fixo">
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-3 ">
                        <label for="cpf-cat" >CPF</label>
                        <input value="<?php echo @$cpf2 ?>" required type="text" class="form-control" id="cpf-cat" name="cpf-cat" placeholder="CPF">
                    </div>
                    <div class="form-group col-md-3 ">
                        <label >RG</label>
                        <input value="<?php echo @$rg2 ?>" type="text" class="form-control" id="rg-cat" name="rg-cat" placeholder="Número do RG">
                    </div>
                    <div class="form-group col-md-3 ">
                        <label >Orgão Emissor</label>
                        <input value="<?php echo @$rg_emissor2 ?>" type="text" class="form-control" id="rg_emissor-cat" name="rg_emissor-cat" placeholder="Orgão emissor">
                    </div>
                    <div class="form-group col-md-3 ">
                        <label >Data de Emissão</label>
                        <input value="<?php echo @$rg_data2 ?>" type="date" class="form-control" id="rg_data-cat" name="rg_data-cat" placeholder="Orgão emissor do RG">
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col-md-3 ">
                        <label >Cidade Natural</label>
                        <input required onkeyup="maiuscula(this)" value="<?php echo @$naturalidade2 ?>" type="text" class="form-control" id="naturalidade-cat" name="naturalidade-cat">
                    </div>
                    <div class="form-group col-md-2 ">
                        <label >UF Natural</label>
                        <select required class="form-control" value="<?php echo @$naturalidadeUF2 ?>" id="UF-cat" name="UF-cat"  >
                          <?php if ($naturalidadeUF2==""){
                            echo '<option selected value=""></option>';
                        } ?>


                        <option <?php echo @$selectedAC ?> value="AC">AC</option>
                        <option <?php echo @$selectedAL ?> value="AL">AL</option>
                        <option <?php echo @$selectedAP ?> value="AP">AP</option>
                        <option <?php echo @$selectedAM ?> value="AM">AM</option>
                        <option <?php echo @$selectedBA ?> value="BA">BA</option>
                        <option <?php echo @$selectedCE ?> value="CE">CE</option>
                        <option <?php echo @$selectedDF ?> value="DF">DF</option>
                        <option <?php echo @$selectedES ?> value="ES">ES</option>
                        <option <?php echo @$selectedGO ?> value="GO">GO</option>
                        <option <?php echo @$selectedMA ?> value="MA">MA</option>
                        <option <?php echo @$selectedMT ?> value="MT">MT</option>
                        <option <?php echo @$selectedMS ?> value="MS">MS</option>
                        <option <?php echo @$selectedPA ?> value="PA">PA</option>
                        <option <?php echo @$selectedPB ?> value="PB">PB</option>
                        <option <?php echo @$selectedPR ?> value="PR">PR</option>
                        <option <?php echo @$selectedPE ?> value="PE">PE</option>
                        <option <?php echo @$selectedPI ?> value="PI">PI</option>
                        <option <?php echo @$selectedRJ ?> value="RJ">RJ</option>
                        <option <?php echo @$selectedRN ?> value="RN">RN</option>
                        <option <?php echo @$selectedRS ?> value="RS">RS</option>
                        <option <?php echo @$selectedRO ?> value="RO">RO</option>
                        <option <?php echo @$selectedRR ?> value="RR">RR</option>
                        <option <?php echo @$selectedSC ?> value="SC">SC</option>
                        <option <?php echo @$selectedSP ?> value="SP">SP</option>
                        <option <?php echo @$selectedSE ?> value="SE">SE</option>
                        <option <?php echo @$selectedTO ?> value="TO">TO</option>
                    </select>
                </div>
                <div class="form-group col-md-3 ">
                    <label >Nacionalidade</label>
                    <input required value="<?php echo @$nacionalidade2 ?>" type="text" class="form-control" onkeyup="maiuscula(this)" id="nacionalidade-cat" name="nacionalidade-cat">
                </div>




            </div>
            <div class="container"><div class="row d-flex justify-content-center mb-3 bg-light"><strong>Endereço</strong></div></div>
            <div class="row">

              <div class="form-group col-md-4 ">
                <label for="cpf-cat" >Logradouro</label>
                <input onkeyup="maiuscula(this)" value="<?php echo $logradouro2 ?>" type="text" class="form-control" id="logradouro-cat" name="logradouro-cat" placeholder="(Rua, AV...)">
            </div>
            <div class="form-group col-md-4 ">
                <label >Complemento</label>
                <input onkeyup="maiuscula(this)" value="<?php echo @$complemento2 ?>" type="text" class="form-control" id="complemento-cat" name="complemento-cat" placeholder="Complemento">
            </div>
            <div class="form-group col-md-4 ">
                <label >Bairro</label>
                <input onkeyup="maiuscula(this)" value="<?php echo @$bairro2 ?>" type="text" class="form-control" id="bairro-cat" name="bairro-cat" placeholder="Bairro">
            </div>


        </div>
        <div class="row">
          <div class="form-group col-md-3 ">
            <label >Cidade</label>
            <input onkeyup="maiuscula(this)" value="<?php echo @$cidade2 ?>" type="text" class="form-control" id="cidade-cat" name="cidade-cat" placeholder="Cidade">
        </div>
        <div class="form-group col-md-2 ">
            <label >UF</label>
            <select class="form-control" value="<?php echo @$uf_endereco ?>" id="uf_endereco-cat" name="uf_endereco-cat"  >

               <?php if ($uf_endereco==""){
                  echo '<option selected value=""></option>';
              } ?>

              <option <?php echo @$selectedAC_ ?> value="AC">AC</option>
              <option <?php echo @$selectedAL_ ?> value="AL">AL</option>
              <option <?php echo @$selectedAP_ ?> value="AP">AP</option>
              <option <?php echo @$selectedAM_ ?> value="AM">AM</option>
              <option <?php echo @$selectedBA_ ?> value="BA">BA</option>
              <option <?php echo @$selectedCE_ ?> value="CE">CE</option>
              <option <?php echo @$selectedDF_ ?> value="DF">DF</option>
              <option <?php echo @$selectedES_ ?> value="ES">ES</option>
              <option <?php echo @$selectedGO_ ?> value="GO">GO</option>
              <option <?php echo @$selectedMA_ ?> value="MA">MA</option>
              <option <?php echo @$selectedMT_ ?> value="MT">MT</option>
              <option <?php echo @$selectedMS_ ?> value="MS">MS</option>
              <option <?php echo @$selectedPA_ ?> value="PA">PA</option>
              <option <?php echo @$selectedPB_ ?> value="PB">PB</option>
              <option <?php echo @$selectedPR_ ?> value="PR">PR</option>
              <option <?php echo @$selectedPE_ ?> value="PE">PE</option>
              <option <?php echo @$selectedPI_ ?> value="PI">PI</option>
              <option <?php echo @$selectedRJ_ ?> value="RJ">RJ</option>
              <option <?php echo @$selectedRN_ ?> value="RN">RN</option>
              <option <?php echo @$selectedRS_ ?> value="RS">RS</option>
              <option <?php echo @$selectedRO_ ?> value="RO">RO</option>
              <option <?php echo @$selectedRR_ ?> value="RR">RR</option>
              <option <?php echo @$selectedSC_ ?> value="SC">SC</option>
              <option <?php echo @$selectedSP_ ?> value="SP">SP</option>
              <option <?php echo @$selectedSE_ ?> value="SE">SE</option>
              <option <?php echo @$selectedTO_ ?> value="TO">TO</option>
          </select>
      </div>
      <div class="form-group col-md-3 ">
          <label >CEP</label>
          <input value="<?php echo @$cep2 ?>" type="text" class="form-control" id="cep-cat" name="cep-cat" placeholder="CEP">
      </div>

      <div class="col-md-3">
        <div class="form-group">
            <label >Foto</label>
            <input type="file" value="<?php echo @$foto2 ?>"  class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
        </div>

        <div id="divImgConta">
            <?php if(@$foto2 != ""){ ?>
                <img src="../img/professores/<?php echo $foto2 ?>" width="50%" id="target">
            <?php  }else{ ?>
                <img src="../img/professores/sem-foto.jpg" width="50%" id="target">
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
    <input value="<?php echo @$id_endereco2 ?>" type="hidden" name="id_endereco" id="id_endereco">

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

<!--MODAL PARA Remover disciplinas do professor -->
<div class="modal" id="modal-remover-disciplinas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remover Disciplinas do Professor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <p>Deseja realmente remover todas as disciplinas cadastradas para esse professor?</p>

                <div align="center" id="mensagem_remover" class="">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-remover">Cancelar</button>
                <form method="post">

                    <input type="hidden" id="id_remover"  name="id_remover" value="<?php echo @$_GET['id'] ?>" required>

                    <button type="button" id="btn-remover" name="btn-remover" class="btn btn-danger">Remover</button>
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

                $query = $pdo->query("SELECT * FROM tbprofessor where IdProfessor = '$id_foto' ");
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

                    $query = $pdo->query("SELECT * FROM tbprofessor where IdProfessor = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome3 = $res[0]['NomeProfessor'];
                    $email3 = $res[0]['Email'];
                    $telefone3 = $res[0]['Celular'];
                    $cpf3 = $res[0]['CPF'];
                    $id_endereco3 = $res[0]['IdEndereco'];
                    $foto3 = $res[0]['foto'];

                    $data3 = $res[0]['DataNascimento'];
                    $sexo3 = $res[0]['Sexo'];
                    
                    
                    $telefone3 = $res[0]['Celular'];
                    $telefone_fixo3 = $res[0]['Fone'];
                    $cpf3 = $res[0]['CPF'];
                    $rg3 = $res[0]['RG'];
                    $foto3 = $res[0]['foto'];
                    $naturalidade3 = $res[0]['NaturalidadeCidade'];
                    $nacionalidade3 = $res[0]['Nacionalidade'];
                    $naturalidadeUF3 = $res[0]['NaturalidadeUF'];
                    $id_endereco3  = $res[0]['IdEndereco'];
                    $rg_emissor3 = $res[0]['RG_OrgaoEmissor'];
                    $rg_data3 = $res[0]['RG_DataEmissao'];
                    $imagem3 = $res[0]['foto'];


                    $query = $pdo->query("SELECT * FROM tbendereco where IdEndereco = '" . $id_endereco3 . "' ");
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
                    <div class="form-group col-md-6">
                      <label >Professor</label>
                      <input onkeyup="maiuscula(this)" disabled value="<?php echo @$nome3 ?>" type="text" class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                      <label >Data de Nascimento</label>
                      <input disabled value="<?php echo @$data3 ?>" type="date" class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                      <label >Sexo</label>
                      <select class="form-control" disabled value="<?php echo @$sexo3 ?>">
                        <option <?php if (@$sexo3 =='M') {

                           ?> selected <?php } ?> value="M">Masculino</option>
                           <option <?php if (@$sexo3 =='F') {

                             ?> selected <?php } ?> value="F">Feminino</option>

                         </select>

                     </div>
                 </div>

                 <div class="row">


                    <div class="form-group col-md-4">
                        <label >Email</label>
                        <input disabled value="<?php echo @$email3 ?>" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label >Celular</label>
                        <input value="<?php echo @$telefone3 ?>" disabled type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label >Telefone Fixo</label>
                        <input disabled value="<?php echo @$telefone_fixo3 ?>" type="text" class="form-control">
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-3 ">
                        <label for="cpf-cat" >CPF</label>
                        <input value="<?php echo @$cpf3 ?>" disabled type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-3 ">
                        <label >RG</label>
                        <input value="<?php echo @$rg3 ?>" type="text" class="form-control" disabled>
                    </div>
                    <div class="form-group col-md-3 ">
                        <label >Orgão Emissor</label>
                        <input value="<?php echo @$rg_emissor3 ?>" type="text" class="form-control" disabled>
                    </div>
                    <div class="form-group col-md-3 ">
                        <label >Data de Emissão</label>
                        <input disabled value="<?php echo @$rg_data3 ?>" type="date" class="form-control">
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col-md-3 ">
                        <label >Cidade Natural</label>
                        <input disabled value="<?php echo @$naturalidade3 ?>" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-2 ">
                        <label >UF Natural</label>
                        <select disabled class="form-control" value="<?php echo @$naturalidadeUF3 ?>"   >
                            <option><?php echo @$naturalidadeUF3 ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 ">
                        <label >Nacionalidade</label>
                        <input disabled value="<?php echo @$nacionalidade3 ?>" type="text" class="form-control">
                    </div>




                </div>
                <div class="container"><div class="row d-flex justify-content-center mb-3 bg-light"><strong>Endereço</strong></div></div>
                <div class="row">

                  <div class="form-group col-md-4 ">
                    <label for="cpf-cat" >Logradouro</label>
                    <input disabled value="<?php echo $logradouro3 ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-md-4 ">
                    <label >Complemento</label>
                    <input disabled value="<?php echo @$complemento3 ?>" type="text" class="form-control">
                </div>
                <div class="form-group col-md-4 ">
                    <label >Bairro</label>
                    <input disabled value="<?php echo @$bairro3 ?>" type="text" class="form-control">
                </div>


            </div>
            <div class="row">
              <div class="form-group col-md-3 ">
                <label >Cidade</label>
                <input disabled value="<?php echo @$cidade3 ?>" type="text" class="form-control">
            </div>
            <div class="form-group col-md-2 ">
                <label >UF</label>
                <select class="form-control" disabled value="<?php echo @$uf_endereco3 ?>" >

                   <option><?php echo @$uf_endereco3 ?></option>
               </select>
           </div>
           <div class="form-group col-md-3 ">
              <label >CEP</label>
              <input value="<?php echo @$cep3 ?>" type="text" class="form-control" disabled >
          </div>



      </div>


  </div>
</div>
</div>
</div>


<div class="modal" id="modal-disciplinas" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Disciplinas do Professor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <small>
                 <table class="table table-bordered">
                  <thead>
                    <tr>
                        <th></th>
                        <th scope="col">Disciplinas</th>

                    </thead>
                    <tbody>
                        <form method="post" id="form2">

                            <?php 

                            $id_professor = $_GET['id'];

                        //VERIFICAR Disciplinas
                            $query_3 = $pdo->query("SELECT * FROM tbdisciplina order by IdDisciplina");
                            $res_3 = $query_3->fetchAll(PDO::FETCH_ASSOC);

                            for ($i2=0; $i2 < count($res_3); $i2++) { 
                              foreach ($res_3[$i2] as $key => $value) {
                              }
                              $id_disciplina = $res_3[$i2]['IdDisciplina'];
                              $nome_disciplina = $res_3[$i2]['NomeDisciplina'];

                              $query_4 = $pdo->query("SELECT * FROM tbprofessordisciplina where IdProfessor = '$id_professor' and IdDisciplina = '$id_disciplina'");
                              $res_4 = $query_4->fetchAll(PDO::FETCH_ASSOC);

                              $id_disciplina_marcado = $res_4[0]['IdDisciplina'];



                              ?>


                              <tr>
                                <td >

                                    <input <?php if(@$id_disciplina == @$id_disciplina_marcado ){ ?> checked <?php

                                    } ?> id="checkboxdisProf" value="<?php echo $id_disciplina ?>" type="checkbox" name="id_disci[]"></td>

                                    <td><?php echo $nome_disciplina ?></td>

                                </tr>



                            <?php  }  ?>

                        </tbody>
                    </table>
                </small>

                <small>
                    <div id="mensagem2">

                    </div>
                </small>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn-cancelar-disciplina">Cancelar</button>


                <input type="hidden" id="id_professor"  name="id_professor" value="<?php echo @$_GET['id'] ?>" required>

                

                <button type="submit" id="btn-disciplina" name="btn-disciplina" class="btn btn-primary">Salvar</button>
            </form>
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
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "disciplinas") {
    echo "<script>$('#modal-disciplinas').modal('show');</script>";
}
if (@$_GET["funcao"] != null && @$_GET["funcao"] == "remover-disciplinas") {
    echo "<script>$('#modal-remover-disciplinas').modal('show');</script>";
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

<!--AJAX PARA INSERÇÃO E EDIÇÃO DAS DISCIPLINAS DO PROFESSOR -->

<script type="text/javascript">
    $("#form2").submit(function () {
        var pag = "<?=$pag?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir-disciplina.php",
            type: 'POST',
            data: formData,

            success: function (mensagem) {

                $('#mensagem2').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar-').click();
                    window.location = "index.php?pag="+pag;

                } else {

                    $('#mensagem2').addClass('text-danger')
                }

                $('#mensagem2').text(mensagem)

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

<!--AJAX PARA EXCLUSÃO DOS DADOS -->
<script type="text/javascript">
    $(document).ready(function () {
        var pag = "<?=$pag?>";
        $('#btn-remover').click(function (event) {
            event.preventDefault();

            $.ajax({
                url: pag + "/remover.php",
                method: "post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (mensagem) {

                    if (mensagem.trim() === 'Removido com Sucesso!!') {


                        $('#btn-cancelar-remover').click();
                        window.location = "index.php?pag=" + pag;
                    }

                    $('#mensagem_remover').text(mensagem)



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



