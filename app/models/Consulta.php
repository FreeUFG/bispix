<?php

class Consulta extends Eloquent{

	public static function executar($query)
	{	$b=0;
		$contador =0;
		$tam = explode(' ', $query);
		$tamcont = count($tam);
        $a=' ';
		while($tam != null){
			if($tam[$contador] != "AND")
			{
				$a = $a.' '.$tam[$contador];
			}
		$contador++;
		}

		$a = explode(' ', $a);
		$b = count($a);

		if($b == 1 )
		{
			return self::consultaSimples($a);
		}
		else
		{
			return self::consultaAND($a);
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
