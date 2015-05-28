<?php

class Colecao extends Eloquent{

	protected $table = 'colecao';

	public static function getNomeColecaoAtual()
	{
		$c = self::where('em_uso', true)->first();

		if($c)
			return $c->nome;
		else
			return 'Nenhuma';
	}
	public static function setNomeColecaoAtual($nomeColecao)
	{
		$colAntiga = self::where('em_uso', true)->first();
		$colAtual = self::where('nome_seletor', $nomeColecao)->first();

		if($colAntiga){
			$colAntiga->em_uso = false;
			$colAntiga->save();
		}

		$colAtual->em_uso = true;
		$colAtual->save();
	}
	
}