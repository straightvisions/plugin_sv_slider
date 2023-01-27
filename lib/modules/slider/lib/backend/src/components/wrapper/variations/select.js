const {__} = wp.i18n;
const { Fragment } = wp.element;
const { Button, Placeholder } = wp.components;

export default function SliderDefault(props){
	const {
		onChange = () => {},
	} = props;
	
	return (
		<Placeholder
			label="SV Slider"
             instructions={ __( 'Please select a slider type:', 'sv-slider' ) }
		>
			<Button isPrimary onClick={() => onChange('default')}>
				{ __( 'Default', 'sv-slider' ) }
			</Button>
			<Button isSecondary onClick={() => onChange('query')}>
				{ __( 'Query', 'sv-slider' ) }
			</Button>
		</Placeholder>
	);
}
