<?php

namespace sv_slider;

require_once('frontend.php');

class slider extends modules {
    private $Frontend = null;

    public function init() {
        $this->register_scripts();

        $this->Frontend = new Frontend(['breakpoints'=>$this->get_breakpoints()], $this);

        add_action('init', array($this, 'register_block'));
    }

    public function register_block(): slider {
        register_block_type(
            $this->get_path('lib/backend/src/components/wrapper/block.json'),
            array('render_callback' => array($this->Frontend, 'render'))
        );

        return $this;
    }

    public function register_scripts(): slider {
		// override Swiffy Default Scripts
	    $this->get_active_core()
	         ->get_script('swiffy')
	         ->set_path(
				 $this->get_path('lib/frontend/css/swiffy-slider-modified.css'),
				 true,
		         $this->get_url('lib/frontend/css/swiffy-slider-modified.css')
	         );

		$this->get_active_core()
	         ->get_script('swiffy_js')
	         ->set_path(
				 $this->get_path('lib/frontend/js/swiffy-slider.js'),
				 true,
		         $this->get_url('lib/frontend/js/swiffy-slider.js')
	         );

		// Admin Scripts
	    $this->get_script('editor_script')
	         ->set_path('lib/backend/js/block.build.js')
	         ->set_type('js')
	         ->set_is_gutenberg()
	         ->set_is_backend();

        $this->get_script('editor_css')
             ->set_path('lib/backend/css/editor.css')
             ->set_is_gutenberg()
             ->set_is_backend();

		// Common
	    $this->get_script('common')
	         ->set_path('lib/frontend/css/common.css')
	         ->set_is_gutenberg()
		     ->set_deps(array($this->get_active_core()->get_script('swiffy')->get_handle()));

        // WooCommerce
	    $this->get_script('wc_handpicked_products')
            ->set_path('lib/frontend/css/woocommerce/handpicked_products.css');

        $this->get_script('wc_product_new')
             ->set_path('lib/frontend/css/woocommerce/product_new.css');

		add_action('admin_init', array($this, 'enqueue_scripts'));

        return $this;
    }

	public function enqueue_scripts(): slider {
		if (is_admin()) {
			$config = json_decode(file_get_contents($this->get_path('lib/backend/src/config.json')));

			$this->get_script('editor_script')->set_localized(
				array_merge(
					[],
					['config' => $config]
				)
			)->set_is_enqueued();

			$this->lib_enqueue_gutenberg('swiffy');
		} else {
			$this->lib_enqueue('swiffy');
		}

		$this->get_script('common')->set_is_enqueued();

		// WooCommerce
		if ( $this->has_block_frontend('woocommerce/handpicked-products') ) {
			$this->get_script('wc_handpicked_products')->set_is_enqueued();
		}

        if ( $this->has_block_frontend('woocommerce/product-new') ) {
            $this->get_script('wc_product_new')->set_is_enqueued();
        }


        return $this;
	}
}