/**
 * WordPress dependencies
 */
const {createBlock} = wp.blocks;

const transforms = {
	from: [
		{
			type: 'block',
			isMultiBlock: true,
			blocks: ['*'],
			__experimentalConvert(blocks) {
				const alignments = ['wide', 'full'];
				
				// Determine the widest setting of all the blocks to be grouped
				const widestAlignment = blocks.reduce(
					(accumulator, block) => {
						const {align} = block.attributes;
						return alignments.indexOf(align) >
						alignments.indexOf(accumulator)
							? align
							: accumulator;
					},
					undefined
				);
				
				const groupInnerBlocks = blocks.map((block) => {
					return createBlock(
						block.name,
						block.attributes,
						block.innerBlocks
					);
				});
				
				return createBlock(
					'straightvisions/sv-slider',
					{
						align: widestAlignment,
					},
					groupInnerBlocks
				);
			},
		},
	],
};

export default transforms;
