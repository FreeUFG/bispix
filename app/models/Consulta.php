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
				return self::consultaFrase($query);
				break;
			case 3:
				return self::verificaConsulta3Termos($query);
				break;
		}
	}
	private static function consultaSimples($query)
	{
		return IndiceInvertido::postings($query);
	}

	private static function consultaAND($query){
		$termos = explode(' ', $query);
		$resposta = array();
		$posts1 = IndiceInvertido::postings($termos[0]);
		$posts2 = IndiceInvertido::postings($termos[2]);
		$tam1 = count($posts1);
		$tam2 = count($posts2);
		$i = 0; $j = 0;
		while( ($i < $tam1) && ($j < $tam2) ){
			if( strcasecmp( current($posts1), current($posts2)) == 0 ){
				array_push($resposta, current($posts1));
				next($posts1); next($posts2);
				$i++; $j++;
			}else{
				if( strcasecmp( current($posts1), current($posts2)) < 0 ){
					next($posts1);
					$i++;
				}else{
					next($posts2);
					$j++;
				}
			}
		}
		return $resposta;
	}

	private static function consultaFrase($query){
		$termos = explode(' ', $query );
		$tam1 = strlen($termos[0]);
		$termos[0] = substr($termos[0], 1, $tam1);
		$tam2 = strlen($termos[1]);
		$termos[1] = substr($termos[1], 0, $tam2-1);
		$query = "$termos[0] AND $termos[1]";
		
		//reposta mostra em quais documentos os termos1 e termos2 estao
		$resposta = self::consultaAND($query);
		$qtdDocumentos = count($resposta);

		$posicoes1 = IndiceInvertido::posicoes($termos[0], $resposta);
		$posicoes2 = IndiceInvertido::posicoes($termos[1], $resposta);

		$respostaConsulta = array();	

		$qtd1 = count(current($posicoes1));
		$qtd2 = count(current($posicoes2));
		reset($resposta);
		reset($posicoes1); reset($posicoes2);
		$i = 0; $j = 0; $r = 0;
		while( list($r, $resp) = each($resposta) ){
			list($i, $pos1) = each($posicoes1);
			list($j, $pos2) = each($posicoes2);
			$encontreiFrase = false;
			while( (list($i, $p1) = each($pos1)) ){
				while( ( list($j, $p2) = each($pos2)) ){
					if( $p1 + 1 == $p2){
						array_push($respostaConsulta, $resp);
						$encontreiFrase = true;
						break;
					}
				}	
				if($encontreiFrase){
					break;
				}	
				reset($pos2);
			}	
		}
		return $respostaConsulta;
	}


	private static function consultaOR($query){
		$termos = explode(' ', $query);
		$resposta = array();
		$posts1 = IndiceInvertido::postings($termos[0]);
		$posts2 = IndiceInvertido::postings($termos[2]);
		$tam1 = count($posts1);
		$tam2 = count($posts2);
		$i = 0; $j = 0;
		while( ($i < $tam1) && ($j < $tam2) ){
			if( strcasecmp( current($posts1), current($posts2)) == 0 ){
				array_push($resposta, current($posts1));
				next($posts1); next($posts2);
				$i++; $j++;
			}else{
				if( strcasecmp( current($posts1), current($posts2)) < 0 ){
					array_push($resposta, current($posts1));
					next($posts1);
					$i++;
				}else{
					array_push($resposta, current($posts2));
					next($posts2);
					$j++;
				}
			}
		}
		if( $j < $tam2){
			while( list($j, $resp) = each($posts2) ){
				array_push($resposta, $resp);
			}
		}else{
			if( $i < $tam1){
				while( list($i, $resp) = each($posts1) ){
					array_push($resposta, $resp);
				}	
			}
		}
		return $resposta;
	}

	private static function consultaXOR($query) {
		$termos = explode(' ', $query);
		$queryAND = "$termos[0] AND $termos[2]";
		$queryOR = "$termos[0] OR $termos[2]";
		$respostaAND = self::consultaAND($query);
		$respostaOR = self::consultaOR($query);
		
		foreach($respostaOR as $i => $docOR) {
			foreach($respostaAND as $docAND) {
				if($docOR == $docAND) {
					unset($respostaOR[$i]);
				}
			}
		}
		return $respostaOR;
	}

	private static function verificaConsulta3Termos($query){
		$termos = explode(' ', $query );
		if( strcasecmp($termos[1], "AND") == 0 ){
			return self::consultaAND($query);
		}else{
			if( strcasecmp($termos[1], "OR") == 0 ){
				return self::consultaOR($query);
			}else{
				if( strcasecmp($termos[1], "XOR") == 0 ){
					return self::consultaXOR($query);
				}
			}
		}
	}


}
