<?php 
$pag = "alunos";
require_once("../conexao.php"); 

@session_start();
    //verificar se o usuário está autenticado
if(@$_SESSION['id_usuario'] == null || @$_SESSION['nivel_usuario'] != 'secretaria'){
    echo "<script language='javascript'> window.location='../index.php' </script>";

} 


?>

<div class="row mt-4 mb-4">
    <a type="button" title="Cadastrar Novo Aluno" class="btn-primary btn-sm ml-3 d-none d-md-block" href="index.php?pag=<?php echo $pag ?>&funcao=novo">Novo Aluno</a>
    <a type="button" title="Cadastrar Novo Aluno" class="btn-primary btn-sm ml-3 d-block d-sm-none" href="index.php?pag=<?php echo $pag ?>&funcao=novo"><i class="fas fa-user-plus"></i></a>
    
</div>


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
                        <th class="">Foto</th>
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
                    <td><?php echo @$nome ?></td>
                    <td class="classe-nova"><?php echo @$dataNascimento ?></td>
                    <td class="classe-nova "><?php echo @$nome_responsavel ?></td>
                    <td class="classe-nova classe-nova-tel"><?php echo $celular ?></td>
                    <td class="text-center"><a href="index.php?pag=<?php echo $pag ?>&funcao=foto&id=<?php echo $id ?>"><img width="30" src="../img/alunos/<?php echo $foto ?>"><a></td>



                        <td>
                            <a href="index.php?pag=<?php echo $pag ?>&funcao=endereco&id=<?php echo $id ?>" class='text-info mr-1' title='Dados do Aluno'><i class="fas fa-info-circle"></i></a>


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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php 
                if (@$_GET['funcao'] == 'editar') {
                    $titulo = "Editar Registro";
                    $id2 = $_GET['id'];

                    $query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '" . $id2 . "' ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);

                    $nome2 = $res[0]['NomeAluno'];
                    $data2 = $res[0]['DataNascimento'];
                    $sexo2 = $res[0]['Sexo'];
                    $mae2 = $res[0]['NomeMae'];
                    $pai2 = $res[0]['NomePai'];
                    $email2 = $res[0]['Email'];
                    $telefone2 = $res[0]['Celular'];
                    $cpf2 = $res[0]['CPF'];
                    $rg2 = $res[0]['RG'];
                    $registro2 = $res[0]['RegistroNascimentoNumero'];
                    $cartorio2 = $res[0]['RegistroNascimentoCartorio'];
                    $livro2 = $res[0]['RegistroNascimentoLivro'];
                    $folha2 = $res[0]['RegistroNascimentoFolha'];
                    $dataRegistro2 = $res[0]['RegistroNascimentoData'];
                    $foto2 = $res[0]['foto'];
                    $naturalidade2 = $res[0]['NaturalidadeCidade'];
                    $nacionalidade2 = $res[0]['Nacionalidade'];
                    $naturalidadeUF2 = $res[0]['NaturalidadeUF'];
                    $id_responsavel2 = $res[0]['IdResponsavel'];

                    $query = $pdo->query("SELECT * FROM tbresponsavel where IdResponsavel = '$id_responsavel2' ");
                    $res_r2 = $query->fetchAll(PDO::FETCH_ASSOC);

                    $cpf_responsavel2 = $res_r2[0]['CPFCNPJ'];


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



             } else {
                $titulo = "Inserir Registro";

            }


            ?>

            <h5 class="modal-title" id="exampleModalLabel"><?php echo @$titulo ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="form" method="POST">
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-9">
                     <div class="row">
                        <div class="form-group col-md-6">
                            <label >Nome do Aluno</label>
                            <input onkeyup="maiuscula(this)" required value="<?php echo @$nome2 ?>" type="text" class="form-control" id="nome-cat" name="nome-cat" placeholder="Nome">
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
                            <div class="form-group col-md-6">
                                <label >Mãe</label>
                                <input onkeyup="maiuscula(this)" required value="<?php echo @$mae2 ?>" type="text" class="form-control" id="mae-cat" name="mae-cat" placeholder="Nome da Mãe">
                            </div>
                            <div class="form-group col-md-6">
                                <label >Pai</label>
                                <input onkeyup="maiuscula(this)"     value="<?php echo @$pai2 ?>" type="text" class="form-control" id="pai-cat" name="pai-cat" placeholder="Nome do Pai">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label >Email</label>
                                <input value="<?php echo @$email2 ?>" type="text" class="form-control" id="email-cat" name="email-cat" placeholder="Email">
                            </div>
                            <div class="form-group col-md-6">
                                <label >Telefone</label>
                                <input value="<?php echo @$telefone2 ?>" type="text" class="form-control" id="telefone-cat" name="telefone-cat" placeholder="Telefone">
                            </div>
                        </div>


                        <div class="row">

                            <div class="form-group col-md-4 ">
                                <label for="cpf-cat" >CPF</label>
                                <input value="<?php echo @$cpf2 ?>" type="text" class="form-control" id="cpf-cat" name="cpf-cat" placeholder="CPF">
                            </div>
                            <div class="form-group col-md-4 ">
                                <label >RG</label>
                                <input value="<?php echo @$rg2 ?>" type="text" class="form-control" id="rg-cat" name="rg-cat" placeholder="RG">
                            </div>
                            <div class="form-group col-md-4 ">
                                <label >CPF do Responsável</label>
                                <input value="<?php echo @$cpf_responsavel2 ?>" required type="text" class="form-control" id="cpf_responsavel-cat" name="cpf_responsavel-cat" placeholder="CPF do Responsável">
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-3 ">
                                <label for="cpf-cat" >Número do Registro</label>
                                <input value="<?php echo @$registro2 ?>" required type="text" class="form-control" id="registro-cat" name="registro-cat" placeholder="Número do Registro">
                            </div>
                            <div class="form-group col-md-2 ">
                                <label >Cartório</label>
                                <input required value="<?php echo @$cartorio2 ?>" type="text" class="form-control" id="cartorio-cat" name="cartorio-cat" placeholder="Cartório">
                            </div>
                            <div class="form-group col-md-2 ">
                                <label >Livro</label>
                                <input required value="<?php echo @$livro2 ?>" type="text" class="form-control" id="livro-cat" name="livro-cat" placeholder="Livro">
                            </div>
                            <div class="form-group col-md-2 ">
                                <label >Folha</label>
                                <input required value="<?php echo @$folha2 ?>" type="text" class="form-control" id="folha-cat" name="folha-cat" placeholder="Folha">
                            </div>
                            <div class="form-group col-md-3 ">
                                <label >Data de Registro</label>
                                <input required value="<?php echo @$dataRegistro2 ?>" type="date" class="form-control" id="dataRegistro-cat" name="dataRegistro-cat">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-3 ">
                                <label >Cidade Natural</label>
                                <input required onkeyup="maiuscula(this)" value="<?php echo @$naturalidade2 ?>" type="text" class="form-control" id="naturalidade-cat" name="naturalidade-cat">
                            </div>
                            <div class="form-group col-md-3 ">
                                <label >UF Natural</label>
                                <select class="form-control" required value="<?php echo @$naturalidadeUF2 ?>" id="UF-cat" name="UF-cat"  >
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




                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Imagem</label>
                            <input type="file" value="<?php echo @$foto2 ?>"  class="form-control-file" id="imagem" name="imagem" onChange="carregarImg();">
                        </div>

                        <div id="divImgConta">
                            <?php if(@$foto2 != ""){ ?>
                                <img src="../img/alunos/<?php echo $foto2 ?>" width="100%" id="target">
                            <?php  }else{ ?>
                                <img src="../img/alunos/sem-foto.jpg" width="100%" id="target">
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
                <input value="<?php echo @$registro2 ?>" type="hidden" name="antigo" id="antigo">


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

                $query = $pdo->query("SELECT * FROM tbaluno where IdAluno = '$id_foto' ");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);


                $imagem4 = $res[0]['foto'];  

            } 


            ?>
            <div id="divImgConta" >

                <img class="rounded mx-auto d-block align-content-center img-fluid" src="../img/alunos  /<?php echo $imagem4 ?>" width="300" height="300" id="target">     

            </div>

        </div>

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

                        <div class="form-group col-md-4 ">
                            <label for="cpf-cat" >CPF</label>
                            <input disabled value="<?php echo @$cpf3 ?>" type="text" class="form-control" >
                        </div>
                        <div class="form-group col-md-4 ">
                            <label >RG</label>
                            <input disabled value="<?php echo @$rg3 ?>" type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-4 ">
                            <label >CPF do Responsável</label>
                            <input disabled value="<?php echo @$cpf_responsavel3 ?>" type="text" class="form-control"  >
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
                            <div class="form-group col-md-3 ">
                                <label >Cidade</label>
                                <input disabled value="<?php echo @$cidade3 ?>" type="text" class="form-control" >
                            </div>
                            <div class="form-group col-md-2 ">
                                <label >UF</label>
                                <select class="form-control" disabled value="<?php echo @$uf_endereco3 ?>"   >


                                    <option value=""><?php echo @$uf_endereco3 ?></option>';



                                </select>
                            </div>
                            <div class="form-group col-md-3 ">
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

            <script>
                function maiuscula(string){
                    res = string.value.toUpperCase();

                    string.value=res;
                }
            </script>



