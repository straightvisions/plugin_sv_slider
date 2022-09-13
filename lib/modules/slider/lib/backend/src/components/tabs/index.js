const {Dashicon, TabPanel} = wp.components;
const {Fragment} = wp.element;
export default function ResponsiveTabs(props){
	const {setAttributes, attributes} = props;
	const activeTab = attributes.currentResponsiveTab;
	
	return(
		<Fragment>
			<TabPanel className={'sv-slider-panelbody'}
			          onSelect={ (tabName) => setAttributes({currentResponsiveTab: tabName }) }
			          activeClass=''
			          tabs={[
				
				          {
					          name: "Mobile",
					          title: <Dashicon icon="smartphone"/>,
					          className: (activeTab === 'Mobile' ? 'is-active ' : '')  + 'tab-icon',
				          },
				
				          {
					          name: "MobileLandscape",
					          title: <Dashicon icon="smartphone" style={{transform: 'rotate(90deg)'}}/>,
					          className: (activeTab === 'MobileLandscape' ? 'is-active ' : '')  + 'tab-icon',
				          },
				
				          {
					          name: "Tablet",
					          title: <Dashicon icon="tablet"/>,
					          className: (activeTab === 'Tablet' ? 'is-active ' : '')  + 'tab-icon',
				          },
				
				          {
					          name: "TabletLandscape",
					          title: <Dashicon icon="tablet" style={{transform: 'rotate(90deg)'}}/>,
					          className: (activeTab === 'TabletLandscape' ? 'is-active ' : '')  + 'tab-icon',
				          },
				
				          {
					          name: "TabletPro",
					          title: <Dashicon icon="tablet" style={{color: 'red'}}/>,
					          className: (activeTab === 'TabletPro' ? 'is-active ' : '')  + 'tab-icon',
				          },
				
				          {
					          name: "TabletProLandscape",
					          title: <Dashicon icon="tablet" style={{transform: 'rotate(90deg)', color: 'red'}}/>,
					          className: (activeTab === 'TabletProLandscape' ? 'is-active ' : '')  + 'tab-icon',
				          },
				
				          {
					          name: "Desktop",
					          title: <Dashicon icon="desktop"/>,
					          className: (activeTab === 'Desktop' ? 'is-active ' : '')  + 'tab-icon',
				          }
			
			
			          ]}
			>
				{(tab) => {
					return <div></div>;
				}}
			</TabPanel>
		</Fragment>
	);
}