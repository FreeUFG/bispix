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
		}
	}
	private static function consultaSimples($query)
	{
		return IndiceInvertido::postings($query);
	}

}
