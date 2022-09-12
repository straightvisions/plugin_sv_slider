/**
 * WordPress dependencies
 */
const {__} = wp.i18n;
import {row, stack} from '@wordpress/icons';

const variations = [
	{
		name: 'sv-slider',
		title: __('SV Slider', 'sv-slider'),
		description: __('Create a slider!', 'sv-slider'),
		attributes: {},
		scope: ['transform'],
		//icon: slides,
	},
	{
		name: 'group-row',
		title: __('Row'),
		description: __('Arrange blocks horizontally.'),
		attributes: {layout: {type: 'flex', flexWrap: 'nowrap'}},
		scope: ['inserter', 'transform'],
		isActive: (blockAttributes) =>
			blockAttributes.layout?.type === 'flex' &&
			(!blockAttributes.layout?.orientation ||
				blockAttributes.layout?.orientation === 'horizontal'),
		icon: row,
	},
	{
		name: 'group-stack',
		title: __('Stack'),
		description: __('Arrange blocks vertically.'),
		attributes: {layout: {type: 'flex', orientation: 'vertical'}},
		scope: ['inserter', 'transform'],
		isActive: (blockAttributes) =>
			blockAttributes.layout?.type === 'flex' &&
			blockAttributes.layout?.orientation === 'vertical',
		icon: stack,
	},
];

export default variations;
