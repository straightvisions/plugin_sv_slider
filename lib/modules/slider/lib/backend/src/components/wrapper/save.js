/**
 * WordPress dependencies
 */
const { InnerBlocks } = wp.blockEditor;

export default function save( props ) {
	const { tagName: TagName = 'div' } = props.attributes;

	return <TagName className={'sv-slider swiffy-slider'} >
		<ul className={'sv-slider-container slider-container'}>
			<InnerBlocks.Content />
		</ul>
		
		<button type="button" className="slider-nav"></button>
		<button type="button" className="slider-nav slider-nav-next"></button>
		
		<div className="slider-indicators">
			<button className="active"></button>
			<button></button>
			<button></button>
		</div>
	</TagName>
}

