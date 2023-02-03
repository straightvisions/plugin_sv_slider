const {__} = wp.i18n;
const { Button, Placeholder } = wp.components;
const {useState} = wp.element;

export default function SliderSelect(props){
	
	const [selectPanel, setSelectPanel] = useState('default');
	
	const {
		onChange = () => {},
		onChangeWooCommerce = () => {},
	} = props;

	if(selectPanel === 'default'){
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
				<Button isSecondary onClick={()=>setSelectPanel('woocommerce')}>
					{ __( 'WooCommerce', 'sv-slider' ) }
				</Button>
			</Placeholder>
		);
	}
	
	if(selectPanel === 'woocommerce'){
		return (
			<Placeholder
				label="SV Slider + WooCommerce"
				instructions={ __( 'Please select a WooCommerce Block.', 'sv-slider' ) }
			>
				<Button isPrimary onClick={()=>setSelectPanel('default')}>
					{ __( '❮', 'sv-slider' ) }
				</Button>
				<Button isSecondary onClick={() => onChangeWooCommerce('handpicked-products')}>
					{ __( 'Handpicked Products', 'sv-slider' ) }
				</Button>
			</Placeholder>
		);
	}
	
}
