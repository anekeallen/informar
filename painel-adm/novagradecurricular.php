
<?php 



$query = $pdo->query("SELECT * FROM tbdisciplina order by NomeDisciplina asc ");
$res5 = $query->fetchAll(PDO::FETCH_ASSOC);



$query = $pdo->query("SELECT * FROM tbserie order by NomeSerie asc ");
$res1 = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < @count($res1); $i++) { 
	foreach ($res1[$i] as $key => $value) {
	}
	$nome_reg2 = $res1[$i]['NomeSerie'];
	$id_reg2 = $res1[$i]['IdSerie'];

} 



?>
<h2 class="mb-5 text-center">Cadastrar Grade Curricular</h2>
<form id="form" method="POST">
	<div class="row">
		<div class="form-group col-6">
			<label ><strong>Ano Letivo</strong></label>
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
		<div class="form-group col-6">
			<label ><strong>Série</strong></label>
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

	</div>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">

		<div class="card-body">
			<div class="table-responsive">
				<h5 class="text-center">Selecione as Disciplinas</h5>

				<table class="table table-bordered" width="100%" cellspacing="0">

					<thead>

						<tr>
							<th class="text-center">Disciplinas</th>

						</tr>
					</thead>

					<tbody>



						<tr>


							<?php  
							$query = $pdo->query("SELECT * FROM tbdisciplina order by NomeDisciplina asc ");
							$res2 = $query->fetchAll(PDO::FETCH_ASSOC);



							for ($i=0; $i < @count($res2); $i++) { 
								foreach ($res2[$i] as $key => $value) {
								}

								$nome_reg3 = $res2[$i]['NomeDisciplina'];
								$id_reg3 = $res2[$i]['IdDisciplina'];

								$query = $pdo->query("SELECT * FROM tbgradecurricular where IdPeriodo = '$id_reg'");
								$res3 = $query->fetchAll(PDO::FETCH_ASSOC);
								

								?>


								<td name=""><?php echo $nome_reg3 ?></td>



								<td ><input id="checkboxdis" value="<?php echo $id_reg3 ?>" type="checkbox" name="id_disci[]"></td>


							</tr>


						<?php }  ?>



					</tbody>

				</table>

				
			</div>

			<a type="button" href="index.php?pag=gradecurricular" class="btn btn-secondary">Voltar</a>
			
			<button type="submit" name="btn-salvar" id="btn-salvar" class="btn btn-primary mt-3 mb-3 ">Salvar</button>

			
			
			<div id="mensagem">

			</div>
			
			
		</div>
	</form>
</div>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
	$("#form").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "gradecurricular/inserir.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {

				$('#mensagem').removeClass()

				if (mensagem.trim() == "Salvo com Sucesso!!") {
					$('#mensagem').addClass('text-success')

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

<script type="text/javascript">
	$("#serie").change(function(){

		var idserie =  $("#serie").val();
		var idano = $("#ano_letivo").val();
		$("input:checkbox").prop('checked', false);
		var xmlhttp = new XMLHttpRequest();
		
		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
				//document.getElementById("mensagem").innerHTML=this.responseText;
				var resposta = this.responseText;

				var id_disciplina = resposta.split(" ");
				var i;

				var tamanho = id_disciplina.length
				var text = "";
				for (i = 0; i < tamanho  ; i++) {
					
					$("input[value='"+id_disciplina[i]+"']").prop('checked', true)

					
				}

				
				
			};

		}

		xmlhttp.open("GET","pegarcheckbox.php?id_serie="+idserie +"&id_ano=" + idano,true);
		xmlhttp.send();

		
	})

</script>

<script type="text/javascript">
	$(document).ready(function () {
		$('#dataTable').dataTable({
			"ordering": false
		})

	});
</script>