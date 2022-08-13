/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
import { group as icon } from '@wordpress/icons';

/**
 * Internal dependencies
 */
import edit from './edit';
import metadata from './block.json';
import save from './save';
import transforms from './transforms';
import variations from './variations';

const { name } = metadata;

export { metadata, name };

export const settings = {
	...metadata,
	icon,
	example: {
		attributes: {
			style: {
				color: {
					text: '#000000',
					background: '#ffffff',
				},
			},
		},
		innerBlocks: [
			{
				name: 'straightvisions/sv-slider-slide',
			},
		],
	},
	//transforms,
	edit,
	save,
	//variations,
};
