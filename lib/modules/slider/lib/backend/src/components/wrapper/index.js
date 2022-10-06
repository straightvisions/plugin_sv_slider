/**
 * WordPress dependencies
 */
const {__} = wp.i18n;
import {group as icon} from '@wordpress/icons';

/**
 * Internal dependencies
 */
import edit from './edit';
import metadata from './block.json';
import save from './save';

const {name} = metadata;

export {metadata, name};

export const settings = {
	...metadata,
	icon,
	example: {
		attributes: {
			className: 'sv-slider swiffy-slider',
			style: {
				color: {
					text: '#000000',
					background: '#ffffff',
				},
			},
		}
	},
	//transforms,
	edit,
	save,
	//variations,
};
