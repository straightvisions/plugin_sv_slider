/**
 * WordPress dependencies
 */
const { useInnerBlocksProps, useBlockProps } = wp.blockEditor;

export default function save( { attributes: { tagName: Tag } } ) {
	return <Tag { ...useInnerBlocksProps.save( useBlockProps.save() ) } />;
}
