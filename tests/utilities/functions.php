<?php 


function make($class, $attr= []){
	return factory($class)->make($attr);
}


function create($class, $attr = []){
	return factory($class)->create($attr);
}


