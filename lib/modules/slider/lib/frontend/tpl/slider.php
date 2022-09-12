<<?php
echo $tag ?> class="wp-block-straightvisions-sv-slider swiffy-slider <?php
echo $attributes['className']; ?> align<?php
echo $attributes['align']; ?> <?php
echo $this->css_selector; ?> slider-nav-animation slider-nav-visible slider-nav-dark">

<div class="slider-container">
    <?php
    echo $content; ?>
</div>

<button type="button" class="slider-nav" aria-label="Go to previous"></button>
<button type="button" class="slider-nav slider-nav-next" aria-label="Go to next"></button>

<div class="slider-indicators">
	<button aria-label="Go to slide" class="active"></button>
</div>

</<?php
echo $tag ?>>
