<?php
namespace sv_slider\css_generator;

class arrows{
    private $selector = '';
    private $reset_round_before = 'background-color: transparent;border-radius: 0;width: 3rem;height: 3rem;padding:0.5rem;';
    private $reset_round_after = 'background-color: transparent;width: 3rem;height: 3rem;margin: 0;';
    private $reset_square_before = 'background-color: transparent;border-radius: 0;width: 3rem;height: 3rem;padding:0.5rem;';
    private $reset_square_after = 'background-color: transparent;width: 3rem;height: 3rem;margin: 0;';

    public function __construct(string $selector = ''){
        $this->selector = $selector;
    }

    public function get_arrow(): array{
        $mask = 'var( --swiffy-slider-nav-mask-arrow );';
        $list = [
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::before' => $this->reset_round_before,
            $this->selector . ' .slider-nav::after' => $this->reset_round_after,
            $this->selector . ' .slider-nav::before' => $this->reset_square_before,
            $this->selector . ' .slider-nav::after' => $this->reset_square_after,
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::after' =>
                'mask: '.$mask . '-webkit-mask: '. $mask,
            //...
        ];

        return $list;
    }

    public function get_arrow_round(): array{
        $mask = 'var( --swiffy-slider-nav-mask-arrow-round );';
        $list = [
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::before' => $this->reset_round_before,
            $this->selector . ' .slider-nav::after' => $this->reset_round_after,
            $this->selector . ' .slider-nav::before' => $this->reset_square_before,
            $this->selector . ' .slider-nav::after' => $this->reset_square_after,
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::after' =>
                'mask: '.$mask . '-webkit-mask: '. $mask
                .'background-color: var(--swiffy-slider-nav-dark);width: 2rem;height: 2rem;margin: .5rem;',
            $this->selector . ' .slider-nav::before' =>
                'background-color: var(--swiffy-slider-nav-light);border-radius: 50%;',

            //...
        ];

        return $list;
    }

    public function get_chevron(): array{
        $mask = 'var( --swiffy-slider-nav-mask-chevron );';
        $list = [
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::before' => $this->reset_round_before,
            $this->selector . ' .slider-nav::after' => $this->reset_round_after,
            $this->selector . ' .slider-nav::before' => $this->reset_square_before,
            $this->selector . ' .slider-nav::after' => $this->reset_square_after,
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::after' =>
                'mask: '.$mask . '-webkit-mask: '. $mask,
            //...
        ];

        return $list;
    }

    public function get_chevron_square(): array{
        $mask = 'var( --swiffy-slider-nav-mask-chevron );';
        $list = [
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::before' => $this->reset_round_before,
            $this->selector . ' .slider-nav::after' => $this->reset_round_after,
            $this->selector . ' .slider-nav::before' => $this->reset_square_before,
            $this->selector . ' .slider-nav::after' => $this->reset_square_after,
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::after' =>
                'mask: '.$mask . '-webkit-mask: '. $mask
                .'background-color: var(--swiffy-slider-nav-dark);width: 1.75rem;height: 1.75rem;',
            $this->selector . ' .slider-nav::before' =>
                'background-color: var(--swiffy-slider-nav-light);border-radius: 0;',
            //...
        ];

        return $list;
    }

    public function get_chevron_compact(): array{
        $mask = 'var( --swiffy-slider-nav-mask-chevron-compact );';
        $list = [
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::before' => $this->reset_round_before,
            $this->selector . ' .slider-nav::after' => $this->reset_round_after,
            $this->selector . ' .slider-nav::before' => $this->reset_square_before,
            $this->selector . ' .slider-nav::after' => $this->reset_square_after,
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::after' =>
                'mask: '.$mask . '-webkit-mask: '. $mask,
            //...
        ];

        return $list;
    }

    public function get_caret(): array{
        $mask = 'var( --swiffy-slider-nav-mask-caret );';
        $list = [
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::before' => $this->reset_round_before,
            $this->selector . ' .slider-nav::after' => $this->reset_round_after,
            $this->selector . ' .slider-nav::before' => $this->reset_square_before,
            $this->selector . ' .slider-nav::after' => $this->reset_square_after,
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::after' =>
                'mask: '.$mask . '-webkit-mask: '. $mask,


            //...
        ];

        return $list;
    }

    public function get_caret_filled(): array{
        $mask = 'var( --swiffy-slider-nav-mask-caret-filled );';
        $list = [
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::before' => $this->reset_round_before,
            $this->selector . ' .slider-nav::after' => $this->reset_round_after,
            $this->selector . ' .slider-nav::before' => $this->reset_square_before,
            $this->selector . ' .slider-nav::after' => $this->reset_square_after,
            // resets------------------------------------------------------------
            $this->selector . ' .slider-nav::after' =>
                'mask: '.$mask . '-webkit-mask: '. $mask,
            //...
        ];

        return $list;
    }

}