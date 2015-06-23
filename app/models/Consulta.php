<?php

class Consulta extends Eloquent{

	public static function executar($query)
	{
		$tam = explode(' ', $query);
		$tam = count($tam);
		switch ($tam) {
			case 1:
				return self::consultaSimples($query);
				break;
			case 2: 
				if($query[0]=="\""){
				return self::consultaPorFrase($query);
				}	
				else {
				return self::consultaSimplesNOT($query);
				}			
				break;
			case 3:
				return self::consultaComposta($query);
				break;
			case 4:
				return self::consultaCompostaUmNOT($query);
				break;	
			case 5:
				return self::consultaCompostaDuploNOT($query);
				break;	
		}
	}
	private static function consultaSimples($query)
	{
		$postings = IndiceInvertido::postings($query);
		return self::RanqueamentoSimples($query,$postings);
		}
	private static function consultaSimplesNOT($query)
	{
		//Quebra a query entre ' '
		$divide = explode(' ', $query);
		switch($divide[0])
		{
			//Caso seja NOT, e porque deseja-se uma consulta NOT
			case "NOT":
			$postings = IndiceInvertido::consultaNOT($divide[1]);
			return self::RanqueamentoSimples($divide[1],$postings);;
			break;

			//Default consulta normal.
			default:
			$postings = IndiceInvertido::postings($divide[0]);
			return self::RanqueamentoSimples($divide[0],$postings);;
			break;
		}
	
	}
	private static function consultaPorFrase($query)
	{
		$postings =array();
		//Verifica a primeira posicao do vetor QUERY,Caso seja "ASPAS", e porque deseja-se uma consulta POR FRASE
		if($query[0]=="\"")
		{
				//Retira aspas da consulta
				$retiraAspas = str_replace(array("\""), "", $query);
				//Quebra a query JA COM AS ASPAS RETIRADAS EM DUAS.
				$divide2 = explode(' ', $retiraAspas);

				$primeiroTermo = IndiceInvertido::consultaPosicao($divide2[0]);
				$segundoTermo = IndiceInvertido::consultaPosicao($divide2[1]);
				$consultaPorFrase = IndiceInvertido::consultaPorFrase($primeiroTermo,$segundoTermo);
				return $consultaPorFrase;
		}

	}
	private static function consultaComposta($query)
	{
		//Quebra a query entre ' '
		$divide = explode(' ', $query);

		//Realiza a consulta do PRIMEIRO e SEGUNDO termos.
		$primeiroTermo = IndiceInvertido::postings($divide[0]);
		$segundoTermo = IndiceInvertido::postings($divide[2]);

		//Realiza o Switch com elemento da posicao 1 do array divide, Para saber qual e o OPERADOR
		switch($divide[1])
		{
			case "OR":
			$result = IndiceInvertido::consultaOR($primeiroTermo,$segundoTermo);
			return self::RanqueamentoComposto($divide[0],$divide[2],$result);
			break;

			case "AND":
			$result = IndiceInvertido::consultaAND($primeiroTermo,$segundoTermo);
			return self::RanqueamentoComposto($divide[0],$divide[2],$result);
			break;

			case "XOR":
			$result = IndiceInvertido::consultaXOR($primeiroTermo,$segundoTermo);
			return self::RanqueamentoComposto($divide[0],$divide[2],$result);
			break;
			//CASO SEJA NENHUM OPERADOR.
			default: 
			return array();
			break;
		}
	}
	private static function consultaCompostaUmNOT($query)
	{
		//Divide a query entre ' '
		$divide = explode(' ', $query);

		//Faz um switch do primeiro elemento do array
		switch($divide[0])
		{
			//Caso ele seja NOT, entao quer dizer que o primeiro termo deverar ser negado
			case "NOT":
			//Realiza a negacao do primeiro termo e consulta o segundo
			$termoNegado = 	IndiceInvertido::consultaNOT($divide[1]);
			$segundoTermo = IndiceInvertido::postings($divide[3]);

			//Realiza o Switch com elemento da posicao 2 do array divide, para saber qual e o OPERADOR
			switch($divide[2])
			{					
				case "OR":
				$result = IndiceInvertido::consultaOR($termoNegado,$segundoTermo);
				return self::RanqueamentoComposto($divide[1],$divide[3],$result);
				break;

				case "AND":
				$result = IndiceInvertido::consultaAND($termoNegado,$segundoTermo);
				return self::RanqueamentoComposto($divide[1],$divide[3],$result);
				break;

				case "XOR":
				$result = IndiceInvertido::consultaXOR($termoNegado,$segundoTermo);
				return self::RanqueamentoComposto($divide[1],$divide[3],$result);
				break;
				//CASO SEJA NENHUM OPERADOR.
				default: 
				return array();
				break;
			}
			break;

			//Caso o primeiro termo nao seja NEGADO, ele entra nesse caso default.E entao assumimos que o segundo termo seja NEGADO.
			default: 
			//Realiza o Switch com o elemento da posicao 2 do array divide, para saber se é mesmo o NOT
				switch($divide[2])
				{
				//CASO SEJA NOT, SIGNIFICA QUE O SEGUNDO TERMO DA CONSULTA DEVERAR SER NEGADO.	
				case "NOT":
				//Realiza a consulta do primeiro termo. E Realiza a consulta negada do segundo termo.
				$primeiroTermo = IndiceInvertido::postings($divide[0]);
				$termoNegado = 	IndiceInvertido::consultaNOT($divide[3]);
				//Realiza o Switch com elemento da posicao 1 do array divide, para saber qual e o OPERADOR
					switch($divide[1])
					{
						case "OR":
						$result = IndiceInvertido::consultaOR($primeiroTermo,$termoNegado);
						return self::RanqueamentoComposto($divide[0],$divide[3],$result);
						break;

						case "AND":
						$result = IndiceInvertido::consultaAND($primeiroTermo,$termoNegado);
						return self::RanqueamentoComposto($divide[0],$divide[3],$result);
						break;

						case "XOR":
						$result = IndiceInvertido::consultaXOR($primeiroTermo,$termoNegado);
						return self::RanqueamentoComposto($divide[0],$divide[3],$result);
						break;
						//CASO SEJA NENHUM OPERADOR.
						default: 
						return array();
						break;
					}
					break;
				default:
				return "";
				break;
			}
			break;
		}
	}
	private static function consultaCompostaDuploNOT($query)
	{
		//Divide a query entre ' '
		$divide = explode(' ', $query);

		//Faz um switch do primeiro elemento do array
		switch($divide[0])
		{
			//Caso ele seja NOT, entao quer dizer que o primeiro termo deverar ser negado
			case "NOT":
			//Realiza outro Switch com elemento da posicao 3 do array divide, para saber SE O SEGUNDO TERMO tambem devera ser NEGADO
				switch($divide[3])
				{	
					//Caso ele seja NOT, entao quer dizer que o segundo termo deverar ser negado
					case "NOT":	
					$primeiroNegado =IndiceInvertido::consultaNOT($divide[1]);
					$segundoNegado =IndiceInvertido::consultaNOT($divide[4]);
					//Realiza Switch com elemento da posicao 2 do array divide, para saber QUAL O OPERADOR
						switch($divide[2])
						{				
							case "OR":
							$result = IndiceInvertido::consultaOR($primeiroNegado,$segundoNegado);
							return self::RanqueamentoComposto($divide[1],$divide[4],$result);
							break;

							case "AND":
							$result = IndiceInvertido::consultaAND($primeiroNegado,$segundoNegado);
							return self::RanqueamentoComposto($divide[1],$divide[4],$result);
							break;

							case "XOR":
							$result = IndiceInvertido::consultaXOR($primeiroNegado,$segundoNegado);
							return self::RanqueamentoComposto($divide[1],$divide[4],$result);
							break;

							//CASO SEJA NENHUM OPERADOR.
							default: 
							return array();
							break;
						}
					//Para o SEGUNDO Case NOT.
					break;

					//CASO o 3º elemento do array divide nao seja NOT, ENCERRA.
					default: 
					return array();
					break;
					}
			//Para o PRIMEIRO case NOT.
			break;

			//CASO O PRIMEIRO ELEMENTO NAO SEJA NOT, ENCERRA.
			default: 
			break;
		}
	}

	//Realiza o ranqueamento dos documentos, de acordo com o Peso.
	public static function RanqueamentoSimples($termo,$documentos){
	//Array que ira guardar os DOCUMENTOSID ordenados.
	$DocIdOrdenados=array();
	$p1=0;

		if (!function_exists('compararPeso')) {
		//Funcao que ordena os array de acordo com a MAIOR FREQUENCIA. 					
		function compararPeso($a, $b){
	        return $a['Peso'] < $b['Peso'];
	    }

     }
    //Realiza a consulta TF-IDF
	$resultado = IndiceInvertido::consultaTF_IDF($termo,$documentos);
	//Realiza a ordenacao, de acordo com a MAIOR FREQUENCIA
	usort($resultado, 'compararPeso');
	//Pega a ordem dos documentos e ADICIONA NO ARRAY $DocIdOrdenados.
			while ($p1!=count($resultado)) {
				array_push($DocIdOrdenados, $resultado[$p1]["Documento"]);
				$p1++;
			}
	return $DocIdOrdenados;
	}
	

	public static function RanqueamentoComposto($termo1,$termo2,$documentos){
	//Array que ira guardar os DOCUMENTOSID ordenados.
	$DocIdOrdenados=array();

	//Array que ira guardar os DocumentosID com seus PESOS ordenados.
	$ResultadosSomadosPeso =array();
	$var1=0;
	$p1 = 0;
	$p2 = 0;

	if (!function_exists('compararPeso')) {
		//Funcao que ordena os array de acordo com a MAIOR FREQUENCIA. 					
		function compararPeso($a, $b){
	        return $a['Peso'] < $b['Peso'];
	    }
	}
	
	//Realiza a consulta TF-IDF
	$resultado = IndiceInvertido::consultaTF_IDF($termo1,$documentos);
	//Realiza a consulta TF-IDF
	$resultado2 = IndiceInvertido::consultaTF_IDF($termo2,$documentos);

		//Realiza uma consulta AND com os 2 RESULTADOS, comparando os "DOCUMENTOS"
		$count = count($resultado);
		$count2 = count($resultado2);
		
		while($p1!=$count && $p2!=$count2) {
				if($resultado[$p1]["Documento"]==$resultado2[$p2]["Documento"]){
					//AO encontrar, pega o peso de cada um, e faz a soma.
					$soma=$resultado[$p1]["Peso"] + $resultado2[$p2]["Peso"];
					$ResultadosSomadosPeso[]=array('Documento' => $resultado[$p1]["Documento"],'Peso'=>$soma);
					$p1++;
					$p2++;
				}
				else if($resultado[$p1]<$resultado2[$p2]){
					$p1++;
				}
				else {
					$p2++;
				}
		}

	//Realiza a ordenacao no array ResultadosSomadosPeso, de acordo com o MAIOR PESO.
	usort($ResultadosSomadosPeso, 'compararPeso');

	//Pega a ordem dos documentos e ADICIONA NO ARRAY DocIdOrdenados, para demonstrar a ordem no ranking.
		while ($var1!=count($ResultadosSomadosPeso)) {
			array_push($DocIdOrdenados, $ResultadosSomadosPeso[$var1]["Documento"]);
			$var1++;
		}
	return $DocIdOrdenados;
	}


}