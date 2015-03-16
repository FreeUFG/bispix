<div class="page-header">
  <h1>Geração do Índice</h1>
</div>

<div class="container-fluid">
	<ul class="nav nav-pills">
		<li class="active">
			<a href="{{ URL::to('/gera-indice') }}">
				<span class="badge">1</span> Coleções
			</a>
		</li>
	  	<li class="disabled">
	  		<a href="#"><span class="badge">2</span> Tokenizer</a>
	  	</li>
	  	<li class="disabled">
	  		<a href="#"><span class="badge">3</span> Pré-processamento</a>
	  	</li>
	  	<li class="disabled">
	  		<a href="#"><span class="badge">4</span> Índice Invertido</a>
	  	</li>
	</ul>
	
	@include($panelName)

</div>