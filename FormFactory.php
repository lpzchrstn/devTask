<?php

$html[] = FormInputFactory::create("text", ["class"=>"primary"])->setName('uname');
$html[] = FormInputFactory::create("textArea")->setRows(4)->setName("description"); 
 
foreach( $html as $ii ) {
    echo $ii . "<br><br>";
}

Class FormInputFactory{
	static $input;

	static function create( $type, Array $attr = [] ) {
		self::$input = $type == 'textArea' ? "<textarea ></textarea>" : "<input type='$type'>";

		foreach( $attr as $atr=>$val ) {
			self::$input = self::concatAttr( $atr, $val );
		}
		return new self;
	}

	function setRows( $num ) {
		self::$input = self::concatAttr( 'rows', $num );
		return new self;
	}

	function setName( $name ) {
		return self::$input = self::concatAttr( 'name', $name );
	}

	static function concatAttr( $attr, $val ){
		return substr_replace( self::$input," $attr='$val'>",strpos( self::$input, '>', 0 ),1 );
	}

}