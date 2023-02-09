<?php
	$content = $this->get_slider_content();

	// handle wrappers and class injection
	$dom = new DOMDocument();
	$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8"), LIBXML_NOERROR);
	$xpath = new DOMXPath($dom);

	if(
	    $xpath->query('//div')->item(0)
	    && $xpath->query('//ul')->item(0)
	    && $xpath->query('//li')->item(0)
	) {
	    $wrapper = $xpath->query('//div')->item(0);
	    $ul      = $xpath->query('//ul')->item(0);
	    $ul->setAttribute('class', 'slider-container');
	    $lis  = $xpath->query("./li", $ul);
	    $html = $dom->saveHTML();
	}else{
		$html = '<p style="text-align:center;font-weight:bold;">No posts to display, please check your query block / filters!</p>';
	    $count = 0;
	}

	echo $html;