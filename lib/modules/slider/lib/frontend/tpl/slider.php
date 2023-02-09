<<?php
echo $this->get_wrapper_tag();
echo $this->get_wrapper_id();
echo $this->get_wrapper_class();
?>>
	<div
	<?php
		echo $this->get_slider_class();
		echo $this->get_slider_data_attr();
	?>>

		<?php
			require($this->get_path('/lib/frontend/tpl/'.str_replace('-','_', $this->get_attr('sliderType','default')).'.php'));
		?>

		<?php if(true === true) : ?>
			<button type="button" class="slider-nav" aria-label="Go to previous"></button>
			<button type="button" class="slider-nav slider-nav-next" aria-label="Go to next"></button>
		<?php endif; ?>

        <?php if($this->get_attr('indicators-style', 'none') !== 'none'){
            $indicators = '<ul class="slider-indicators">';

            $indicators .= '<li class="active"></li>';

            for($i = 2; $i <=  $this->slides_count; $i++){
                $indicators .= '<li></li>';
            }

            $indicators .= '</ul>';

            echo $indicators;
        } ?>

	</div>
</<?php echo $this->get_wrapper_tag('tag'); ?>>