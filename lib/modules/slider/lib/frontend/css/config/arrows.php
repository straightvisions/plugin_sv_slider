<?php

namespace sv_slider\css_generator;

class arrows {
	private $selector = '';
	private $reset_round_before = 'background-color: transparent;border-radius: 0;width: 3rem;height: 3rem;padding:0;';
	private $reset_round_after = 'background-color: transparent;width: 3rem;height: 3rem;';
	private $reset_square_before = 'background-color: transparent;border-radius: 0;width: 3rem;height: 3rem;padding:0;';
	private $reset_square_after = 'background-color: transparent;width: 3rem;height: 3rem;';

	public function __construct(string $selector = '') {
		$this->selector = $selector;
	}

	public function get_arrow(): array {
		$mask = 'var( --swiffy-slider-nav-mask-arrow );';
		$list = $this->get_preset_list();
		// custom stuff
		$list[$this->selector . ' .slider-nav::after'] = 'mask: ' . $mask . '-webkit-mask: ' . $mask;
		$list[$this->selector . ' .slider-nav::after'] .= 'background-color: var(--swiffy-slider-arrows-color)';

		return $list;
	}

	private function get_preset_list(): array {
		return [
			// resets------------------------------------------------------------
			$this->selector . ' .slider-nav::before' => $this->reset_round_before,
			$this->selector . ' .slider-nav::after'  => $this->reset_round_after,
			$this->selector . ' .slider-nav::before' => $this->reset_square_before,
			$this->selector . ' .slider-nav::after'  => $this->reset_square_after,
			// resets------------------------------------------------------------
		];
	}

	public function get_arrow_round(): array {
		$mask = 'var( --swiffy-slider-nav-mask-arrow-round );';
		$list = $this->get_preset_list();
		// custom stuff
		// custom stuff
		$list[$this->selector . ' .slider-nav::after']  .= 'mask: ' . $mask . '-webkit-mask: ' . $mask;
		$list[$this->selector . ' .slider-nav::after']  .=
			'background-color: var(--swiffy-slider-arrows-color);width: 2rem;height: 2rem;margin: .5rem;';
		$list[$this->selector . ' .slider-nav::before'] .=
			'background-color: var(--swiffy-slider-arrows-color-background);border-radius: 50%;';

		return $list;
	}

	public function get_chevron(): array {
		$mask = 'var( --swiffy-slider-nav-mask-chevron );';
		$list = $this->get_preset_list();
		// custom stuff
		$list[$this->selector . ' .slider-nav::after'] .= 'mask: ' . $mask . '-webkit-mask: ' . $mask;
		$list[$this->selector . ' .slider-nav::after'] .= 'background-color: var(--swiffy-slider-arrows-color)';

		return $list;
	}

	public function get_chevron_square(): array {
		$mask = 'var( --swiffy-slider-nav-mask-chevron );';
		$list = $this->get_preset_list();
		// custom stuff
		$list[$this->selector . ' .slider-nav::after']  .= 'mask: ' . $mask . '-webkit-mask: ' . $mask;
		$list[$this->selector . ' .slider-nav::after']  .=
			'background-color: var(--swiffy-slider-arrows-color);';
		$list[$this->selector . ' .slider-nav::before'] .=
			'background-color: var(--swiffy-slider-arrows-color-background);border-radius: 0;';

		return $list;
	}

	public function get_chevron_compact(): array {
		$mask = 'var( --swiffy-slider-nav-mask-chevron-compact );';
		$list = $this->get_preset_list();
		// custom stuff
		$list[$this->selector . ' .slider-nav::after'] .= 'mask: ' . $mask . '-webkit-mask: ' . $mask;
		$list[$this->selector . ' .slider-nav::after'] .= 'background-color: var(--swiffy-slider-arrows-color)';

		return $list;
	}

	public function get_caret(): array {
		$mask = 'var( --swiffy-slider-nav-mask-caret );';
		$list = $this->get_preset_list();
		// custom stuff
		$list[$this->selector . ' .slider-nav::after'] .= 'mask: ' . $mask . '-webkit-mask: ' . $mask;
		$list[$this->selector . ' .slider-nav::after'] .= 'background-color: var(--swiffy-slider-arrows-color)';

		return $list;
	}

	public function get_caret_filled(): array {
		$mask = 'var( --swiffy-slider-nav-mask-caret-filled );';
		$list = $this->get_preset_list();
		// custom stuff
		$list[$this->selector . ' .slider-nav::after'] .= 'mask: ' . $mask . '-webkit-mask: ' . $mask;
		$list[$this->selector . ' .slider-nav::after'] .= 'background-color: var(--swiffy-slider-arrows-color)';

		return $list;
	}

}