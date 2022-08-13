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

const { name } = metadata;

export { metadata, name };

export const settings = {
	...metadata,
	icon,
	example: {
		innerBlocks: [
			{name: 'core/cover'}
		],
	},
	//transforms,
	edit,
	save,
	//variations,
};
