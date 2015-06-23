<?php

class Colecao extends Eloquent{

	protected $table = 'colecao';

	public static function setColecao($nomeColecao)
	{
		$c = self::where('nome', $nomeColecao)->first();

		if($c)
			return "Colecao ja Cadastrada";
		else
			$colecaotable = new Colecao;
			$colecaotable->nome = $nomeColecao;
			$colecaotable->nome_seletor = $nomeColecao;
			$colecaotable->endereco = $nomeColecao;
			$colecaotable->em_uso = false;
			$colecaotable->save();
	}
	public static function getNomeColecaoAtual()
	{
		$c = self::where('em_uso', true)->first();

		if($c)
			return $c->nome;
		else
			return 'Nenhuma';
	}
	public static function getEnderecoColecaoAtual()
	{
		$c = self::where('em_uso', true)->first();

		if($c)
			return $c->endereco;
		else
			return 'sem-colecao';
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
