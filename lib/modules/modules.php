<?php
	namespace sv_plugin_boilerplate;
	
	class modules extends init {
		public function __construct() {
		
		}
		
		public function init() {
			$this->load_module('common');
		}
	}