<<?php
echo $tag; echo $id;?> class="wp-block-straightvisions-sv-slider slider-indicators-round swiffy-slider slider-nav-visible<?php
echo empty($attributes['className']) ? '' : ' '.$attributes['className']; ?> align<?php
echo isset($attributes['align']) ? $attributes['align'] : ''; ?> <?php
echo $this->class_selector; ?> " <?php
echo $attributes['_data']; ?>>

<div class="slider-container">
    <?php
    echo $content; ?>
</div>

<button type="button" class="slider-nav" aria-label="Go to previous"></button>
<button type="button" class="slider-nav slider-nav-next" aria-label="Go to next"></button>

<?php if(1===1){
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
