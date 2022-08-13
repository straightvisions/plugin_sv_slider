import {settings as wrapperSettings} from './components/wrapper';
import {settings as slideSettings} from './components/slide';

const { registerBlockType } = wp.blocks;

registerBlockType('straightvisions/sv-slider-slide', slideSettings);
registerBlockType('straightvisions/sv-slider', wrapperSettings);
