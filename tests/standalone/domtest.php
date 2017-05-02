<?php

require("../../bootstrap/autoload.php");


$string = "<div id='testbox'>
           <div><img id='l1' src='111'/></div>
           <div><img  id='l2' src='111'/></div>
           </div>";

$html = \Sunra\PhpSimple\HtmlDomParser::str_get_html($string);

$images= $html->find('img');
foreach($images as $image){
	$image->setAttribute('width',100);
}

echo $html;