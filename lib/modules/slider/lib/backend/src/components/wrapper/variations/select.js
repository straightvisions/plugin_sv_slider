const {__} = wp.i18n;
const { Button, Placeholder } = wp.components;

export default function SliderDefault(props){
	const {
		onChange = () => {},
	} = props;
	
	return (
		<Placeholder
			label="SV Slider"
             instructions={ __( 'Please place the slider into a query block for post template mode.', 'sv-slider' ) }
		>
			<Button isPrimary onClick={() => onChange('default')}>
				{ __( 'Images & Content', 'sv-slider' ) }
			</Button>
			<Button isSecondary onClick={() => onChange('post-template')}>
				{ __( 'Post Template', 'sv-slider' ) }
			</Button>
		</Placeholder>
	);
}
