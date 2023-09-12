<?php

$content = $this->get_slider_content();

// handle wrappers and class injection
$dom = new DOMDocument();
$dom->loadHTML($content, LIBXML_NOERROR);
$xpath = new DOMXPath($dom);

if (
	$xpath->query('//div')->item(0)
	&& $xpath->query('//ul')->item(0)
	&& $xpath->query('//li')->item(0)
) {
	$wrapper = $xpath->query('//div')->item(0);
	$ul      = $xpath->query('//ul')->item(0);
	$ul->setAttribute('class', 'slider-container');
	$lis = $xpath->query("./li", $ul);
	$wrapper->parentNode->replaceChild($ul, $wrapper);
	$html  = $dom->saveHTML();
	$count = $this->set_slides_count($lis->length);
}

echo $html;