<<?php
echo $tag ?> class="wp-block-straightvisions-sv-slider swiffy-slider slider-nav-visible<?php
echo $attributes['className']; ?> align<?php
echo isset($attributes['align']) ? $attributes['align'] : ''; ?> <?php
echo $this->class_selector; ?> " <?php
echo $attributes['_data']; ?>>

<div class="slider-container">
    <?php
    echo $content; ?>
</div>

<button type="button" class="slider-nav" aria-label="Go to previous"></button>
<button type="button" class="slider-nav slider-nav-next" aria-label="Go to next"></button>

</<?php
echo $tag ?>>
