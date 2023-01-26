<?php
$alignment = isset($attributes['align']) ? 'align' . $attributes['align'] : '';

$indicators = [
	'style' => isset($attributes['svSlider']['indicators-style']) ? 'slider-indicators-'.$attributes['svSlider']['indicators-style'] : '',
	'dark' => isset($attributes['svSlider']['indicators-dark']) ? 'slider-indicators-dark' : '',
	'outside' => isset($attributes['svSlider']['indicators-outside']) ? 'slider-indicators-outside' : '',
	'highlight' => isset($attributes['svSlider']['indicators-highlight']) ? 'slider-indicators-highlight' : '',
	'visible-sm' => isset($attributes['svSlider']['indicators-visible-sm']) ? 'slider-indicators-sm' : '',
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
?>

<<?php echo $tag . $id . ' ' . $attributes['_data'];?> class="<?php echo $classnames; ?>">

<div class="slider-container">
    <?php echo $content; ?>
</div>

<button type="button" class="slider-nav" aria-label="Go to previous"></button>
<button type="button" class="slider-nav slider-nav-next" aria-label="Go to next"></button>

<?php if(isset($attributes['svSlider']['indicators-style']) && $attributes['svSlider']['indicators-style'] !== 'none'){
	$indicators = '<ul class="slider-indicators">';

	$count = isset($attributes['svSlider']['childrenCount']) && (int)$attributes['svSlider']['childrenCount'] > 0 ? (int)$attributes['svSlider']['childrenCount'] : 1;

    $indicators .= '<li class="active"></li>';

	for($i = 2; $i <= $count; $i++){
        $indicators .= '<li></li>';
	}

    $indicators .= '</ul>';

	echo $indicators;
} ?>

</<?php
echo $tag ?>>
