<?php

class PrincipalController extends BaseController {

	public function index()
	{
		return View::make('template.index');
	}

	public function resultados()
	{
		$data = Principal::parametros('resultados');
		return View::make('template.empty', $data);
	}

}
