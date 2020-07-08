<?php 


function make($class, $attr= [], $times = null){
	return factory($class, $times)->make($attr);
}


function create($class, $attr = [], $times = null){
	return factory($class, $times)->create($attr);
}


