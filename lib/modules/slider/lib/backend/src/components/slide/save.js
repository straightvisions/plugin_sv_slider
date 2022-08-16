/**
 * WordPress dependencies
 */
const { InnerBlocks } = wp.blockEditor;

export default function save( props ) {
	const { tagName: TagName = 'li' } = props.attributes;
	
	return <TagName className={'sv-slider-slide'} >
			<InnerBlocks.Content />
	</TagName>
}

