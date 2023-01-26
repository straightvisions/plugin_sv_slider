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
?>

<<?php echo $tag . $id . ' ' . $attributes['_data'];?> class="<?php echo $classnames; ?>">

<div class="slider-container">
    <?php echo $content; ?>
</div>

<button type="button" class="slider-nav" aria-label="Go to previous"></button>
<button type="button" class="slider-nav slider-nav-next" aria-label="Go to next"></button>

<?php if($attributes['svSlider']['indicators-style'] !== 'none'){
	$indicators = '<ul class="slider-indicators">';

	$count = isset($attributes['svSlider']['childrenCount']) && (int)$attributes['svSlider']['childrenCount'] > 0 ? (int)$attributes['svSlider']['childrenCount'] : 1;

	for($i = 1; $i <= $count; $i++){
        $indicators .= '<li></li>';
	}

    $indicators .= '</ul>';

	echo $indicators;
} ?>

</<?php
echo $tag ?>>
