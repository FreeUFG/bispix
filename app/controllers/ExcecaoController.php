<?php

class ExcecaoController extends BaseController {

	public function bancoPronto()
	{
		$data = Excecao::parametros('bancoPronto');
		return View::make('template.excecao', $data);
	}

}
