<?php

$content = $this->get_slider_content();

// handle wrappers and class injection
$dom = new DOMDocument();
$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR);
$xpath = new DOMXPath($dom);

if (
	$xpath->query('//div')->item(0)
	&& $xpath->query('//ul')->item(0)
	&& $xpath->query('//li')->item(0)
) {
	$wrapper = $xpath->query('//div')->item(0);
	$ul      = $xpath->query('//ul')->item(0);
	$ul->setAttribute('class', 'slider-container');
	$lis  = $xpath->query("./li", $ul);
	$html = $dom->saveHTML($ul); // Save only the modified <ul> element
} else {
	$html  = '<p style="text-align:center;font-weight:bold;">No posts to display, please check your query block / filters!</p>';
	$count = $this->set_slides_count(0);
}

echo $html;
