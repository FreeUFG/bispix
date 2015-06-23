<?php

class IndiceInvertido extends Eloquent{

	protected $table = 'indice';

	private static function prepararBanco()
	{
		$nomeTabela = (new self)->getTable();

		if( ! Schema::hasTable($nomeTabela) ){
			Artisan::call('migrate:refresh');
			Artisan::call('db:seed');
		}
		else if(self::count() != 0){
			self::truncate();
		}

	}
	public static function tokenizer($nomeDiretorio)
	{
		$endAbsoluto = app_path().'/data/colecoes/'.$nomeDiretorio;
		$lista = self::listaDiretorio($endAbsoluto);
		$tam = count($lista);

		$log = app_path().'/data/colecoes/log.txt';

		$i=1;
		foreach($lista as $arq){

			$logFile = fopen($log,'w');
			$data = $i."-".$tam."-".$arq;
			fwrite($logFile, $data);
			fclose($logFile);
			$i++;

			$pont = fopen($endAbsoluto.'/'.$arq,'r');
			if($pont){
				$posicao = 0;
				while(true) {
					$linha = fgets($pont);
					if ($linha==null) break;

					$termos = explode(' ', $linha);

					foreach($termos as $t){

						$tripla = new IndiceInvertido;
						$valor = trim($t);

						if( strlen($valor) ){
							$posicao++;
							$tripla->termo = $t;
							$tripla->documento = $arq;
							$tripla->posicao = $posicao;
							$tripla->save();
						}
					}
				}
				fclose($pont);
			}
		}

		//Limpando o log do arquivo
		$logFile = fopen($log,'w');
		$data = "";
		fwrite($logFile, $data);
		fclose($logFile);
	}
	private static function listaDiretorio($nomeDiretorio)
	{

		$lista = scandir($nomeDiretorio);
		$chave = array_search(".", $lista);
		unset($lista[$chave]);
		$chave = array_search("..", $lista);
		unset($lista[$chave]);

		return $lista;
	}
	public static function normalizacao()
	{
		$triplas = self::all();
		$tam = $triplas->count();
		$log = app_path().'/data/colecoes/log.txt';

		$i = 1;
		foreach ($triplas as $t) {
			$logFile = fopen($log,'w');
			$data = $i."-".$tam;
			fwrite($logFile, $data);
			fclose($logFile);
			$i++;

			$termo = $t->termo;
			$termo = self::normalizar($termo);

			$t->termo = $termo;
			$t->save();
		}

		//Limpando o log do arquivo
		$logFile = fopen($log,'w');
		$data = "";
		fwrite($logFile, $data);
		fclose($logFile);
	}
	private static function normalizar($termo)
	{
		$simbolosRemocao =
			array(
				"?", "!", ",", ";", "(",
				")", "'\'", ":", ".","-","%","º","\"","$","[","]"
			);
		$termoNormalizado = str_replace($simbolosRemocao, "", $termo);
		$termoNormalizado = mb_strtolower($termoNormalizado);

		return $termoNormalizado;
	}
	public static function postings($query)
	{
		//Consulta simples de somente um termo na query
		$postings = IndiceInvertido::select('documento')
							->where('termo', $query)
							->distinct()
							->lists('documento');
		return $postings;
		break;
	}
	public static function parametros($nomeMetodo)
	{
		switch($nomeMetodo){
			case 'passo-1':
				return self::parametrosPasso1();
				break;
			case 'passo-2':
				return self::parametrosPasso2();
				break;
			case 'passo-3':
				return self::parametrosPasso3();
				break;
			case 'passo-4':
				return self::parametrosPasso4();
				break;
			case 'fim':
				return self::parametrosFim();
				break;
		}
	}
	private static function parametrosPasso1()
	{
		self::prepararBanco();

		$data['viewName'] = 'site.gerar-indice.index';
		$data['panelName'] = 'site.gerar-indice.passo-1.index';
		$data['scriptName'] = 'block.script';

		$data['navAtivo'] = 'passo-1';
		$data['panelUrl'] = URL::to('/gerar-indice/passo-2');
        $data['panelId'] = 'colecaoForm';
        $data['panelNext'] = 'Próximo';
        $data['panelIcon'] = 'forward';

        return $data;
	}
	private static function parametrosPasso2()
	{
		$data['viewName'] = 'site.gerar-indice.index';
		$data['panelName'] = 'site.gerar-indice.passo-2.index';
		$data['scriptName'] = 'site.gerar-indice.passo-2.script';

		$data['navAtivo'] = 'passo-2';
		$data['panelUrl'] = URL::to('/gerar-indice/passo-3');
        $data['panelId'] = 'colecaoForm';
        $data['panelNext'] = 'Próximo';
        $data['panelIcon'] = 'forward';

        return $data;
	}
	private static function parametrosPasso3()
	{
		$data['viewName'] = 'site.gerar-indice.index';
		$data['panelName'] = 'site.gerar-indice.passo-3.index';
		$data['scriptName'] = 'site.gerar-indice.passo-3.script';

		$data['navAtivo'] = 'passo-3';
		$data['panelUrl'] = URL::to('/gerar-indice/passo-4');
        $data['panelId'] = 'colecaoForm';
        $data['panelNext'] = 'Próximo';
        $data['panelIcon'] = 'forward';

        return $data;
	}
	private static function parametrosPasso4()
	{
		$data['viewName'] = 'site.gerar-indice.index';
		$data['panelName'] = 'site.gerar-indice.passo-4.index';
		$data['scriptName'] = 'block.script';

		$data['navAtivo'] = 'passo-4';
		$data['panelUrl'] = URL::to('/gerar-indice/fim');
        $data['panelId'] = 'colecaoForm';
        $data['panelNext'] = 'Próximo';
        $data['panelIcon'] = 'forward';

        return $data;
	}
	private static function parametrosFim()
	{
		$data['viewName'] = 'site.gerar-indice.index';
		$data['panelName'] = 'site.gerar-indice.fim.index';
		$data['scriptName'] = 'block.script';

		$data['navAtivo'] = 'fim';
		$data['panelUrl'] = URL::to('/');
        $data['panelId'] = 'colecaoForm';
        $data['panelNext'] = 'OK';
        $data['panelIcon'] = 'ok';

        return $data;
	}

	public static function consultaNOT($termo)
	{
		//Consulta DE TODOS OS DOCUMENTOS
		$TodosDocumentos = IndiceInvertido::select('documento')
							->distinct()
							->lists('documento');	
		//Consulta simples DE DOCUMENTOS com o termo						
		$serNegado= self::postings($termo);	
		
		//Vai percorrer os 2 arrays, e quando encontrar o respectivo termo nos documentos, nao adiciona ele na lista
		$p1 = 0;
		$p2 = 0;
		$count = count($serNegado);
		$count2 = count($TodosDocumentos);
		$result =array();
		while($p1!=$count && $p2!=$count2) {
			if($serNegado[$p1]==$TodosDocumentos[$p2]){
					$p1++;
					$p2++;
				}
			else if($serNegado[$p1]<$TodosDocumentos[$p2]){
					array_push($result,$serNegado[$p1]);
					$p1++;
				}
			else {
					array_push($result,$TodosDocumentos[$p2]);
					$p2++;
				}
			}	
			if($p1!=$count){
			while($p1!=$count) {
			array_push($result,$serNegado[$p1]);
			$p1++;
			}	
		}	
		else if($p2!=$count2){
			while($p2!=$count2) {
			array_push($result,$TodosDocumentos[$p2]);
			$p2++;
			}	
		}
		return $result;
	}
	//Percorre os 2 arrays, adicionando os valores no ARRAY result
	public static function consultaOR($arrayTermo1,$arrayTermo2)
	{
		$p1 = 0;
		$p2 = 0;
		$count = count($arrayTermo1);
		$count2 = count($arrayTermo2);
		$result =array();
		while($p1!=$count && $p2!=$count2) {
			if($arrayTermo1[$p1]==$arrayTermo2[$p2]){
					array_push($result,$arrayTermo1[$p1]);
					$p1++;
					$p2++;
				}
			else if($arrayTermo1[$p1]<$arrayTermo2[$p2]){
					array_push($result,$arrayTermo1[$p1]);
					$p1++;
				}
			else {
					array_push($result,$arrayTermo2[$p2]);
					$p2++;
				}
		}
		if($p1!=$count){
			while($p1!=$count) {
			array_push($result,$arrayTermo1[$p1]);
			$p1++;
			}	
		}	
		else if($p2!=$count2){
			while($p2!=$count2) {
			array_push($result,$arrayTermo2[$p2]);
			$p2++;
			}	
		}	
		return $result;
	}

	//Percorre os 2 ARRAYS, mais so adiciona no ARRAY result se os 2 termos conter no MESMO documento
	public static function consultaAND($arrayTermo1,$arrayTermo2) {
		$p1 = 0;
		$p2 = 0;
		$count = count($arrayTermo1);
		$count2 = count($arrayTermo2);
		$result =array();
		while($p1!=$count && $p2!=$count2) {
				if($arrayTermo1[$p1]==$arrayTermo2[$p2]){
					array_push($result,$arrayTermo1[$p1]);
					$p1++;
					$p2++;
				}
				else if($arrayTermo1[$p1]<$arrayTermo2[$p2]){
					$p1++;
				}
				else {
					$p2++;
				}
			}
		return $result;
	}
	//Percorre os 2 ARRAYS, mais adiciona no ARRAY result TODOS documentos onde nao contem o TERMO
	public static function consultaXOR($arrayTermo1,$arrayTermo2) {		
		$p1 = 0;
		$p2 = 0;
		$count = count($arrayTermo1);
		$count2 = count($arrayTermo2);
		$result =array();
		while($p1!=$count && $p2!=$count2) {
				if($arrayTermo1[$p1]==$arrayTermo2[$p2]){
					$p1++;
					$p2++;
				}
				else if($arrayTermo1[$p1]<$arrayTermo2[$p2]){
					array_push($result,$arrayTermo1[$p1]);
					$p1++;
				}
				else if($arrayTermo1[$p1]>$arrayTermo2[$p2]){
					array_push($result,$arrayTermo2[$p2]);
					$p2++;
				}		
			}
	return $result;
	}

	//Consulta todas posicoes do termo no banco;
	public static function consultaPosicao($termo){
		$postings = IndiceInvertido::select('posicao','documento')
		 					->where('termo', $termo)
		 					->get()
		 					->toArray();
		return $postings;
		break;
	}	

	//Realiza a consulta por frase	entre os 2 termos
	public static function consultaPorFrase($arrayPrimeiroTermo,$arraySegundoTermo) {
		$p1 = 0;
		$p2 = 0;
		$count = count($arrayPrimeiroTermo);
		$count2 = count($arraySegundoTermo);
		$Docs =array();
		while($p1!=$count && $p2!=$count2) {
			$posAtual  =$arrayPrimeiroTermo[$p1]["posicao"];
			$posAtual2  =$arraySegundoTermo[$p2]["posicao"];
			$docAtual = $arrayPrimeiroTermo[$p1]["documento"];
			$docAtual2 = $arraySegundoTermo[$p2]["documento"];

			//Compara os 2 arrays para encontrar OS MESMOS DOCUMENTOS
			if($docAtual==$docAtual2)
			{	
				//Se encontrar, verifica a posAtual+1 do primeiro mais a posAtual
	   			if($posAtual+1  ==   $posAtual2){					
					array_push($Docs, $arrayPrimeiroTermo[$p1]["documento"]);
				}
				else if( $posAtual+1   <   $posAtual2){
					
				$p1++;
				}
				else {
					$p2++;
				}

			$p1++;
			$p2++;
			}
			else if($docAtual<$docAtual2){
				$p1++;
			}
			else {
				$p2++;
			}
		}
		
		return $Docs;
	}
	//Consulta todos os termos no documento passado por referencia. Usado para calcular o TERMFREQUENCIA
	private static function consultaTermosDocumentoID($documento){
		$postings = IndiceInvertido::select('termo')
					->where('documento', $documento)
					->distinct()
					->lists('termo');
					return $postings;
	}

	//Calcula o IDF, com BASE na QUANTIDADE TOTAL de arquivos da colecao, pela quantidade de arquivos que o termo aparece.
	public static function valorIDF($QuantDocumentosComTermo)
	{
		if ($QuantDocumentosComTermo!=0) {
			return log10(100/$QuantDocumentosComTermo);
		}
		return 0;
	}

	//RETORNA O VALOR TF-IDF 
	private static function valorTF_IDF($TF,$IDF){
		return $TF*$IDF;
	}

	//Consulta a TF no DOCUMENTO, e com isso ja calcula o TF_IDF de cada documento.
	public static function consultaTF_IDF($termo,$documentos){	
	//Converte o termo em minusculo
	$termo=strtolower($termo);	
	$frenquenciaTodos =array();

	//Quantidade de documentos que contem a query
	$DF=count($documentos);

	//Realiza o calculo de IDF, de acordo com O DF;
	$IDF=self::valorIDF($DF);

	//Varre o array DOCUMENTOS,fazendo uma pesquisa DO TERMO em CADA DOCUMENTO.
	foreach ($documentos as $documentoID) {
		//Realiza a consulta de todos os termos no documento especifico..
		$todosTermos =self::consultaTermosDocumentoID($documentoID);
		//Se ja achou uma frequencia no documento, entao assumios que seja 1
		$TF=1;
				//Varre o array TODOTERMOS(DOCUMENTO ESPECIFICO) e encontra a frequencia do termo no documento.
				foreach ($todosTermos as $value) {
					if($value==$termo){
					$TF++;
					}

				}	

		//Realiza o calculo de TF-IDF, de acordo com o TF E IDF;
		$TF_IDF =self::valorTF_IDF($TF,$IDF);

	//Adiciona no array multidimencional. DocumentoID, e Peso do documento.
	$frenquenciaTodos[]=array('Documento' => $documentoID,'Peso'=>$TF_IDF);
	}
	return $frenquenciaTodos;
	}
	
}
