<?php

class IndiceInvertido extends Eloquent{

	protected $table = 'indice';
	
	private static function listaDiretorio($nomeDiretorio)
	{
		
		$lista = scandir($nomeDiretorio);
		$chave = array_search(".", $lista);
		unset($lista[$chave]);
		$chave = array_search("..", $lista);
		unset($lista[$chave]);

		return $lista;
	}	
	public static function quebraPalavras($nomeDiretorio)
	{
		$endAbsoluto = app_path().'/data/colecoes/'.$nomeDiretorio;
		$lista = self::listaDiretorio($endAbsoluto);

		$log = app_path().'/data/colecoes/log.txt';

		foreach($lista as $arq){
			
			$logFile = fopen($log,'w');
			$data = "Indexando o arquivo ".$arq." ...";
			fwrite($logFile, $data);
			fclose($logFile);

			$pont = fopen($endAbsoluto.'/'.$arq,'r');
			if($pont){
				$posicao = 0;
				while(true) {
					$linha = fgets($pont);
					if ($linha==null) break;

					$termos = explode(' ', $linha);
						
					foreach($termos as $t){
						$valor = trim($t);
						if( strlen($valor) ){
							$posicao++;
							$registro = array(
								'termo' => $t,
								'documento' => $arq,
								'posicao' => $posicao
							);
							DB::table('indice')->insert( $registro );
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
	public static function bancoPronto()
	{
		$nomeTabela = (new self)->getTable();

		if( Schema::hasTable($nomeTabela) ){
			$val = self::all();
			if(count($val) == 0) 
				return true;
		}
		return false;		
	}
	public static function parametros($nomeMetodo)
	{
		switch($nomeMetodo){
			case 'index':
				return self::parametrosIndex();
				break;
		}
	}
	private static function parametrosIndex()
	{
		$data['viewName'] = 'block.gerarIndice.index';
		$data['panelName'] = 'block.gerarIndice.colecao';
		$data['scriptName'] = 'block.scriptGeraIndice';

		$data['navAtivo'] = 'colecoes';
		$data['panelUrl'] = URL::to('/gerar-indice/tokenizer');
        $data['panelId'] = 'colecaoForm';
        $data['panelNext'] = 'Próximo';
        $data['panelIcon'] = 'forward';

        return $data;
	}
}