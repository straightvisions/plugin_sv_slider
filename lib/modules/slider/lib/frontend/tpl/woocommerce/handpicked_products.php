<?php
$alignment = isset($attributes['align']) ? 'align' . $attributes['align'] : '';

$indicators = [
    'style' => $attributes['svSlider']['indicators-style'] ? 'slider-indicators-'.$attributes['svSlider']['indicators-style'] : '',
    'dark' => $attributes['svSlider']['indicators-dark'] ? 'slider-indicators-dark' : '',
    'outside' => $attributes['svSlider']['indicators-outside'] ? 'slider-indicators-outside' : '',
    'highlight' => $attributes['svSlider']['indicators-highlight'] ? 'slider-indicators-highlight' : '',
    'visible-sm' => $attributes['svSlider']['indicators-visible-sm'] ? 'slider-indicators-sm' : '',
];

$classnames = array_filter([
    // Gutenberg classnames
    $attributes['className'],
    // block id selector class
    $this->class_selector,
    // alignment
    $alignment,
    'swiffy-slider',
    // setting based classes
    'slider-nav-visible', // to be moved to setting
    $indicators['style'],
    $indicators['dark'],
    $indicators['outside'],
    $indicators['highlight'],
    $indicators['visible-sm']
]);

$count = isset($attributes['svSlider']['childrenCount']) && (int)$attributes['svSlider']['childrenCount'] > 0 ? (int)$attributes['svSlider']['childrenCount'] : 1;
$html = '<p style="text-align:center;font-weight:bold;">Something went wrong with the query content!</p>';

// render inner blocks first -------------------------------------------------------
$blocks = parse_blocks($content);
$content = '';

foreach ($blocks as $block) {
    $content .= render_block($block);
}

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
    // add woocommerce related classes ---------------------------------------------
	$wrapper_classes = $wrapper->getAttribute('class');
    $classnames[] = 'wc-block-grid';
	if(strpos($wrapper_classes, 'has-aligned-buttons')){
        $classnames[] = 'has-aligned-buttons';
	}

	// handle ul and li ------------------------------------------------------------
    $ul = $xpath->query('//ul')->item(0);
    $ul->setAttribute('class', 'wc-block-grid__products slider-container');
    $lis  = $xpath->query("./li", $ul);

	// replace div wrapper from the block ------------------------------------------
    $wrapper->parentNode->replaceChild($ul, $wrapper);
    $html = $dom->saveHTML();
}else{
    $html = '<p style="text-align:center;font-weight:bold;">No posts to display, please check your query block / filters!</p>';
    $count = 0;
}

// wrapper classnames to string ----------------------------------------------------
$classnames = implode(' ', $classnames);

// build the html output -----------------------------------------------------------
?>
<<?php echo $tag . $id . ' ' . $attributes['_data'];?> class="<?php echo $classnames; ?> slider-type-woocommerce slider-woocommerce-type-handpicked-products">

	<?php echo $html; ?>

	<?php
	// add nav buttons -------------------------------------------------------------
	if($count > 0): ?>
		<button type="button" class="slider-nav" aria-label="Go to previous"></button>
		<button type="button" class="slider-nav slider-nav-next" aria-label="Go to next"></button>
	<?php endif; ?>

	<?php
    // add indicators ---------------------------------------------------------------
	if($attributes['svSlider']['indicators-style'] !== 'none' && $count > 0){
	    $indicators = '<ul class="slider-indicators">';
	    $indicators .= '<li class="active"></li>';

	    for($i = 2; $i <= $count; $i++){
	        $indicators .= '<li></li>';
	    }

	    $indicators .= '</ul>';

	    echo $indicators;
	} ?>

</<?php
echo $tag ?>>
