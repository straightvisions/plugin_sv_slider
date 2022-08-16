window.addEventListener('load', function(){
	sv_slider_init();
});

function sv_slider_init(){
	const sliders = document.querySelectorAll('.sv-slider');
	console.log(sliders);
	
	for(let i=0;i<sliders.length;i++){
		sliders[i].setAttribute('data-slider-id', i+1);
	}
	
	window.swiffyslider.init();
}