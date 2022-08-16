/**
 * WordPress dependencies
 */
const { InnerBlocks, useInnerBlocksProps, useBlockProps } = wp.blockEditor;

export default function save( props ) {
	const blockProps = useBlockProps.save();
	const innerBlocksProps = useInnerBlocksProps.save(blockProps);
	
	return <li {...innerBlocksProps} />;
}
