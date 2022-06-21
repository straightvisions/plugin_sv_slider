<?php
	namespace sv_slider;
	
	class slider extends modules {
		public function __construct() {
		
		}
		
		public function init() {
			$this->set_section_title( __( 'Slider', 'sv_slider' ) )
				->set_section_type( 'settings' )
				->load_settings()
				->get_root()->add_section( $this );
			
			add_action( 'init', array($this, 'register_block') );
			add_action( 'init', array($this, 'register_scripts') );

		}
		
		protected function load_settings(): slider{
			$this->get_setting( 'my_setting' )
				->set_title( __( 'My Setting', 'sv100' ) )
				->set_description( __( 'Some text', 'sv100' ) )
				->load_type( 'text' );
				
			return $this;
		}
		
		public function register_block(): slider{
			$path = $this->get_path('block.json') ;
			
			if ( is_string( $path ) && file_exists( $path ) ) {
				register_block_type_from_metadata( $path,
					array('render_callback' => array($this, 'render_block'))
				);
			}
			
			return $this;
		}
		
		public function register_scripts(): slider {
			
			if(is_admin()){
				/*
				$this->get_script('sv_slider_editor_script')
				     ->set_path('lib/backend/slider/js/xxxxx.js')
				     ->set_type('js')
				     ->set_is_gutenberg()
				     ->set_is_backend()
				     ->set_is_enqueued();

				
				$this->get_script('sv_slider_editor_css')
				     ->set_path('lib/backend/css/xxxx.css')
				     ->set_is_gutenberg()
				     ->set_is_backend()
				     ->set_is_enqueued();*/
			}
			
			return $this;
		}
		
	}