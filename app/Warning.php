<?php

namespace Lakeview;

class Warning
{
	public $warnings;
	private $new;
	private $colours = array('dark','primary','link','');
	private $warning;

	private function createNew(){
		$this->new = new \stdClass();
		$this->new->options = new \stdClass();
		return $this;
	}
	
	public function add($name, $options=null){
			dump(is_object($this->new));
		if(!is_object($this->new)){	$this->createNew(); }
		$this->new->name = $name;
		return $this;
	}
	
	public function options($optionsArray){
		foreach($optionsArray as $option => $value){
			$options = $this->new->options;
			switch($option){
					case 'needsForm':
						$options->form = (!empty($value))? $value:false;
					break;
					case 'url':
						$options->url = (!empty($value))? $value:null;
					break;
					case 'colour':
						
					break;
			}
				
		}
	}
	
	public function all(){
		return $this;
	}
}
