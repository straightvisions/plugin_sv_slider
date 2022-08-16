/**
 * WordPress dependencies
 */
const { InnerBlocks, useInnerBlocksProps, useBlockProps } = wp.blockEditor;

export default function save(props) {
	const { tagName: TagName = 'div' } = props.attributes;
	const blockProps = useBlockProps.save();
	const innerBlocksProps = useInnerBlocksProps.save(blockProps);
	
	return ( <TagName {...blockProps} className={'wp-block-straightvisions-sv-slider swiffy-slider'}>
		<ul {...innerBlocksProps} className={'slider-container'} />
		
		<button type="button" className="slider-nav"></button>
		<button type="button" className="slider-nav slider-nav-next"></button>
		
		<div className="slider-indicators">
			<button className="active"></button>
			<button></button>
			<button></button>
		</div>
	</TagName> );
}

