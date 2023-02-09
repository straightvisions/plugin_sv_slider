<?php

namespace sv_slider;

require_once('frontend.php');

class slider extends modules {
    private $Frontend = null;

    public function init() {
        $this->set_section_title(__('Slider', 'sv_slider'))
             ->set_section_type('settings')
             ->load_settings()
             ->get_root()->add_section($this);

        $this->Frontend = new Frontend(['breakpoints'=>$this->get_breakpoints()]);

        add_action('init', array($this, 'register_block'));
        add_action('init', array($this, 'register_scripts'));
    }

    protected function load_settings(): slider {
        $this->get_setting('my_setting')
             ->set_title(__('My Setting', 'sv100'))
             ->set_description(__('Some text', 'sv100'))
             ->load_type('text');

        return $this;
    }

    public function register_block(): slider {
        $path = $this->get_path('lib/backend/src/components/wrapper/block.json');

        if (is_string($path) && file_exists($path)) {
            register_block_type(
                $path,
                array('render_callback' => array($this->Frontend, 'render'))
            );
        }

        return $this;
    }

    public function register_scripts(): slider {

        // woocommerce detection
        if ( class_exists( 'WooCommerce' ) ) {
            $this->get_script('sv_slider_woocommerce_handpicked_products_css')
                 ->set_path('lib/frontend/css/woocommerce/handpicked_products.css')
                 ->set_is_enqueued();
        }

        if (is_admin()) {
            ob_start();
            require($this->get_path('lib/backend/src/config.json'));
            $config = json_decode(ob_get_clean());

            $this->get_script('sv_slider_editor_script')
                 ->set_path('lib/backend/js/block.build.js')
                 ->set_type('js')
                 ->set_is_gutenberg()
                 ->set_is_backend()
                 ->set_localized(
                     array_merge(
                         [],
                         ['config' => $config]
                     )
                 )
                 ->set_is_enqueued();

            $this->get_script('sv_slider_swiffy_slider_css')
                 ->set_path('lib/frontend/css/swiffy-slider-modified.css')
                 ->set_is_gutenberg()
                 ->set_is_backend()
                 ->set_is_enqueued();

            $this->get_script('sv_slider_common_css')
                 ->set_path('lib/frontend/css/common.css')
                 ->set_is_gutenberg()
                 ->set_is_backend()
                 ->set_is_enqueued();

            $this->get_script('sv_slider_swiffy_slider_js')
                 ->set_path('lib/frontend/js/swiffy-slider.js')
                 ->set_is_gutenberg()
                 ->set_is_backend()
                 ->set_type('js')
                 ->set_is_enqueued();

            $this->get_script('editor_components')
                 ->set_is_backend()->set_is_gutenberg()->set_path('lib/backend/css/common/editor_components.css');
        } else {
            $this->get_script('sv_slider_swiffy_slider_css')
                 ->set_path('lib/frontend/css/swiffy-slider-modified.css')
                 ->set_is_enqueued();

            $this->get_script('sv_slider_common_css')
                 ->set_path('lib/frontend/css/common.css')
                 ->set_is_enqueued();

            $this->get_script('sv_slider_swiffy_slider_js')
                 ->set_path('lib/frontend/js/swiffy-slider.js')
                 ->set_type('js')
                 ->set_is_enqueued();
        }



        return $this;
    }


}