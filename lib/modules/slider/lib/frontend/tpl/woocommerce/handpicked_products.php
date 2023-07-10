<?php
	$content = empty($this->get_slider_content()) ? '<p></p>' : $this->get_slider_content();

	// handle wrappers and class injection ---------------------------------------------
	$dom = new DOMDocument();
	$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8"), LIBXML_NOERROR);
	$xpath = new DOMXPath($dom);

	if(

	    $xpath->query('//div')->item(0)
	    && $xpath->query('//ul')->item(0)
	    && $xpath->query('//li')->item(0)
	) {
		// get the originally wrapper from the block -----------------------------------
	    $wrapper = $xpath->query('//div')->item(0);
		// handle ul and li ------------------------------------------------------------
	    $ul = $xpath->query('//ul')->item(0);
	    $ul->setAttribute('class', 'wc-block-grid__products slider-container');
	    $lis  = $xpath->query("./li", $ul);
		$count = $this->set_slides_count($lis->length);
	    $html = $dom->saveHTML();
	}else{
	    $html = '<p style="text-align:center;font-weight:bold;">No posts to display, please check your query block / filters!</p>';
	    $count = $this->set_slides_count(0);
	}

	echo $html;
