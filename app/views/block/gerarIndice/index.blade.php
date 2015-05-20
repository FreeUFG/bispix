<?php
	$nav = array(  
		'colecoes' => 'disabled',
		'tokenizer' => 'disabled',
		'preprocessamento' => 'disabled',
		'indice' => 'disabled'
	);

	$nav[$navAtivo] = "active";
  ?>

<div class="page-header">
  <h1>Geração do Índice</h1>
</div>

<div class="container-fluid">
	<ul class="nav nav-pills">
		<li id="aba-colecao" class="{{ $nav['colecoes'] }}">
			<a><span class="badge">1</span> Coleções</a>
		</li>
	  	<li id="aba-tokenizer" class="{{ $nav['tokenizer'] }}">
	  		<a><span class="badge">2</span> Tokenizer</a>
	  	</li>
	  	<li id="aba-preprocessamento" class="{{ $nav['preprocessamento'] }}">
	  		<a><span class="badge">3</span> Pré-processamento</a>
	  	</li>
	  	<li id="aba-indice" class="{{ $nav['indice'] }}">
	  		<a><span class="badge">4</span> Índice Invertido</a>
	  	</li>
	</ul>

	<div class="panel panel-default">
	
	{{ Form::open(
		array(
          'url' => $panelUrl,
          'class' => 'form-horizontal',
          'id' => $panelId,
          'method' => 'put'
        )) 
    }}
    	<div class="panel-body" style="height: 14em">

			@include($panelName)

		</div>
		<div class="panel-footer text-right">
			<button type="submit" class="btn btn-primary">
				{{ $panelNext }} &nbsp; <span class="glyphicon glyphicon-{{ $panelIcon }}"></span>
			</button>
		</div>
	{{ Form::close() }}
	
</div>
	
	

</div>