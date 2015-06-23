<?php

class Consulta extends Eloquent{

	public static function executar($query)
	{	
		$b=0;
		$contador =0;
		$tam = explode(' ', $query);
		$tamm = $tam;
		$tam = count($tam);
        
        switch($tam){
        	case 1: 	return self::consultaSimples($query);
        
break;
			default: 
			$a=' ';
		while($contador <= $tam){
			if($tamm[$contador] != "AND")
			{
				$a = $a.' '.$tam[$contador];
			}
		$contador++;
		}
		$palavras = explode(' ', $a);
		$b = count($a);
		
		return self::consultaAND($query);
		
}

	}
	private static function consultaSimples($query)
	{
		return IndiceInvertido::postings($query);
	}

	private static function consultaAND($query)
		{	
			
			return IndiceInvertido::postingsAnd($query);
		}

}
