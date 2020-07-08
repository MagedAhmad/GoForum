<?php 


namespace App\Inspections;

class InvalidKeywords {

	protected $keyWords = [
		'Yahoo customer service',
	];

	public function detect($body) {	
		foreach($this->keyWords as $keyword) {
			
			if(stripos($body, $keyword) !== false) {
				throw new \Exception("Your reply contains spam!");
			}
		}

	}
}