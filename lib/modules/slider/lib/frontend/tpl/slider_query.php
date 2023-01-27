<?php
$alignment = isset($attributes['align']) ? 'align' . $attributes['align'] : '';

$indicators = [
	'style' => $attributes['svSlider']['indicators-style'] ? 'slider-indicators-'.$attributes['svSlider']['indicators-style'] : '',
	'dark' => $attributes['svSlider']['indicators-dark'] ? 'slider-indicators-dark' : '',
	'outside' => $attributes['svSlider']['indicators-outside'] ? 'slider-indicators-outside' : '',
	'highlight' => $attributes['svSlider']['indicators-highlight'] ? 'slider-indicators-highlight' : '',
	'visible-sm' => $attributes['svSlider']['indicators-visible-sm'] ? 'slider-indicators-sm' : '',
];

$classnames = implode(' ', array_filter([
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
	$indicators['visible-sm'],
]));

$html = '<p style="text-align:center;font-weight:bold;">Something went wrong with the query content!</p>';
// render inner blocks first
$blocks = parse_blocks($content);
$content = '';

foreach ($blocks as $block) {
    $content .= render_block($block);
}

// handle wrappers and class injection
$dom = new DOMDocument();
$dom->loadHTML($content, LIBXML_NOERROR);
$xpath = new DOMXPath($dom);

if(
    $xpath->query('//div')->item(0)
	&& $xpath->query('//ul')->item(0)
	&& $xpath->query('//li')->item(0)
){
    $wrapper = $xpath->query('//div')->item(0);
    $ul = $xpath->query('//ul')->item(0);
    $ul->setAttribute('class', 'slider-container');
    $lis = $xpath->query("./li", $ul);
    $wrapper->parentNode->replaceChild($ul, $wrapper);
    $html = $dom->saveHTML();
	$count = $lis->length;
}

?>

<<?php echo $tag . $id . ' ' . $attributes['_data'];?> class="<?php echo $classnames; ?>">

<?php echo $html; ?>

<button type="button" class="slider-nav" aria-label="Go to previous"></button>
<button type="button" class="slider-nav slider-nav-next" aria-label="Go to next"></button>

<?php if($attributes['svSlider']['indicators-style'] !== 'none'){
	$indicators = '<ul class="slider-indicators">';
    $indicators .= '<li class="active"></li>';

    $count = isset($attributes['svSlider']['childrenCount']) && (int)$attributes['svSlider']['childrenCount'] > 0 ? (int)$attributes['svSlider']['childrenCount'] : 1;

    for($i = 2; $i <= $count; $i++){
        $indicators .= '<li></li>';
	}

    $indicators .= '</ul>';

	echo $indicators;
} ?>

</<?php
echo $tag ?>>
