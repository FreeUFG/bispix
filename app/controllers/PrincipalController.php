<?php

class PrincipalController extends BaseController {

	public function index()
	{
		return View::make('template.index');
	}

	public function results()
	{
		$data['viewName'] = 'block.resultsList';
		$data['scriptName'] = 'block.scriptResults';
		return View::make('template.empty', $data);
	}

}
