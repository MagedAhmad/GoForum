<?php 


namespace App\Filters;


use Illuminate\Http\Request;
use App\User;

abstract class Filter {

	protected $request;
	protected $builder;
	protected $filters = [];

	public function __construct(Request $request){
		$this->request = $request;
	}

	public function apply($builder){
		$this->builder = $builder;
		foreach($this->getFilters() as $filter => $value) {
			$this->$filter($value);
		}
	}



	public function getFilters(){
		return $this->request->only($this->filters);
	}


} 