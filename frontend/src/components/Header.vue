<template>
  <div class="header h-12 bg-gray-700 flex flex-row items-center shadow-md z-30">
	<img src="@/assets/img/logo.svg" width="35px" class="header-img ml-10">
	     
	<span class="header-text font-normal text-gray-100 text-md ml-4">Learn with Video</span>

	<div class="right-0 mr-10 flex flex-row absolute float-right items-center">
	  <input id="navSearch" class="header-search shadow appearance-none border rounded w-full py-1 px-3 text-grey-400 tracking-wider font-light focus:outline-none focus:shadow-outline"
	  		 type="text" placeholder="Search videos">

	  <div class="">
		<img src="@/assets/img/settings.svg" width="30px" class="header-settings ml-5"/>
	  </div>
	</div>
  </div>
</template>

<script>
export default {
	name: 'Header',
	data() {
		return {
		timeoutHide: 500,
		showHeader: true,
		onOutWait: false,
		navSearch: null,
		}
	},

	mounted() {
		this.navSearch = document.getElementById("navSearch");
		
		var vm = this;

		// vm.onOutWait = true;
		// setTimeout(function() {
		// 	vm.showHeader = false;
		// }, vm.timeoutHide + 1000);

		window.addEventListener("mousemove", function(e) {
			vm.animateHeader(e.y);
			// if (e.y <= 0) {
			// 	vm.showHeader = true;
			// 	vm.onOutWait = false;
			// } else if (e.y > 45) {
				
			// 	if (vm.onOutWait == false) {
			// 		if (e.y >= 500) {
			// 			vm.onOutWait = true;
			// 			setTimeout(function() {
			// 				vm.showHeader = false;
			// 				vm.navSearch.blur();
			// 			}, vm.timeoutHide);
			// 		}
			// 	}
			// }
		});
	},
	//* TODO https://www.trysmudford.com/blog/linear-interpolation/ -> https://codepen.io/trys/pen/XPaYBj/
	methods: {
		animateHeader(mouseY) {
			// let header = document.querySelector('.header');
			// header.setAttribute('style',`height:${this.headLerp(2.5, 2, mouseY)}rem; background-color: rgb(${this.headLerp(74, 40, mouseY)}, ${this.headLerp(85, 50, mouseY)}, ${this.headLerp(104, 67, mouseY)});')`);
			// console.log(this.headLerp(5,10,mouseY));
			var start = 46;
			var end = 60;

			var searchBar = document.querySelector('.header-search');
			var isFocused = (document.activeElement === searchBar);
			if (isFocused) {
				mouseY = 0;
			}

			const elements = [
				{
					element: document.querySelector('.header'),
					items: [
						{
							y1: start,                // Scroll tracking start point
							y2: end,               // Scroll tracking end point
							property: '--height', // CSS Custom property
							from: 3,               // CSS property lower limit
							to: 1,               // CSS property upper limit
							value: 0,              // Starting point
							suffix: "rem"           // Optional suffix (px, deg, turn)
						},
						{
							y1: start,          
							y2: end,            
							property: '--color',
							from: '#4a5568',    
							to: '#1a202c',      
							value: 0,           
							suffix: "#"         
						}
					],
				},
				{
					element: document.querySelector('.header-img'),
					items: [
						{
							y1: start,                // Scroll tracking start point
							y2: end,               // Scroll tracking end point
							property: '--xTranslate', // CSS Custom property
							from: 0,               // CSS property lower limit
							to: -50,               // CSS property upper limit
							value: 0,              // Starting point
							suffix: "%"           // Optional suffix (px, deg, turn)
						},
						{
							y1: start,            
							y2: end,              
							property: '--opacity',
							from: 1,              
							to: 0.3,              
							value: 0,             
							suffix: ""           
						},
						{
							y1: start,          
							y2: end,            
							property: '--scale',
							from: 1,            
							to: 0.3,            
							value: 0,           
							suffix: ""          
						}
					],
				},
				{
					element: document.querySelector('.header-text'),
					items: [
						{
							y1: start,               
							y2: end,              
							property: '--xTranslate',
							from: 0,              
							to: -50,              
							value: 0,             
							suffix: "%"           
						},
						{
							y1: start,            
							y2: end,              
							property: '--opacity',
							from: 1,             
							to: 0,               
							value: 0,            
							suffix: ""           
						},
						{
							y1: start,          
							y2: end,            
							property: '--scale',
							from: 1,            
							to: 0.6,            
							value: 0,           
							suffix: ""          
						}
					],
				},
				{
					element: document.querySelector('.header-search'),
					items: [
						{
							y1: start,          
							y2: end,            
							property: '--color',
							from: '#ffffff',    
							to: '#838383',      
							value: 0,           
							suffix: "#"         
						},
						{
							y1: start,            
							y2: end,              
							property: '--opacity',
							from: 1,              
							to: 0.3,              
							value: 0,             
							suffix: ""           
						},
						{
							y1: start,          
							y2: end,            
							property: '--scale',
							from: 1,            
							to: 0.3,            
							value: 0,           
							suffix: ""          
						}
					],
				},
				{
					element: document.querySelector('.header-settings'),
					items: [
						{
							y1: start,           
							y2: end,             
							property: '--rotate',
							from: 0,             
							to: 43.6,            
							value: 0,            
							suffix: "deg"        
						},
						{
							y1: start,           
							y2: end,             
							property: '--color', 
							from: '#ffffff',     
							to: '#838383',       
							value: 0,            
							suffix: "#"          
						},
						{
							y1: start,            
							y2: end,              
							property: '--opacity',
							from: 1,              
							to: 0.3,              
							value: 0,             
							suffix: ""           
						},
						{
							y1: start,          
							y2: end,            
							property: '--scale',
							from: 1,            
							to: 0.6,            
							value: 0,           
							suffix: ""          
						}
					],
				}
			];

			elements.forEach(lp => {
				let element = lp.element;
				lp.items.forEach(item => {
					// Calculate where we are between y1 and y2
					const n = invlerp(item.y1, item.y2, mouseY)
					if (item.value < item.y1) {
						item.value = item.y1;
					} else if (item.value > item.y2) {
						item.value = item.y2;
					}
					if (item.value !== n) {
						item.value = n
						// Run the visual updates in the next available frame
						window.requestAnimationFrame(() => {
							// Calculate the new value with the invlerp result
							let property
							if (item.suffix == "#") {
								property = lerpColor(item.from, item.to, item.value)
								item.suffix = "";
							} else {
								property = lerp(item.from, item.to, item.value)
							}
							// Set the CSS Custom Property
							element.style.setProperty(item.property, property + (item.suffix || ''))
						})
					}
				});
				
			});
		},
	},
}

const lerp = (x, y, a) => x * (1 - a) + y * a;
const invlerp = (a, b, v) => clamp(( v - a ) / ( b - a ));
const clamp = (v, min = 0, max = 1) => Math.min(max, Math.max(min, v));
function lerpColor(a, b, amount) { 
    var ah = parseInt(a.replace('#', '0x'), 16),
        ar = ah >> 16, ag = ah >> 8 & 0xff, ab = ah & 0xff,
        bh = parseInt(b.replace('#', '0x'), 16),
        br = bh >> 16, bg = bh >> 8 & 0xff, bb = bh & 0xff,
        rr = ar + amount * (br - ar),
        rg = ag + amount * (bg - ag),
        rb = ab + amount * (bb - ab);

    return '#' + ((1 << 24) + (rr << 16) + (rg << 8) + rb | 0).toString(16).slice(1);
}
</script>

<style scoped>
.header {
	--height: 1rem;
	--color: #1a202c;
	height: var(--height);
	min-height: var(--height);
	background-color: var(--color);
}
.header-img {
	--opacity: 0.3;
	--scale: 0.6;
	--xTranslate: -50;
	opacity: var(--opacity);
	transform: scale(var(--scale), var(--scale)) translate(var(--xTranslate),0);
}
.header-text {
	--opacity: 0;
	--scale: 0.6;
	--xTranslate: -50%;
	opacity: var(--opacity);
	transform: scale(var(--scale), var(--scale)) translate(var(--xTranslate),0);
}
.header-search {
	--color: #8383834d;
	--opacity: 0.3;
	--scale: 0.6;
	opacity: var(--opacity);
	transform-origin: 100% 53%;
	transform: scale(var(--scale), var(--scale));
	background-color: var(--color);
}
.header-settings {
	--opacity: 0.4;
	--scale: 0.6;
	--rotate: -50deg;
	opacity: var(--opacity);
	transform: scale(var(--scale), var(--scale)) rotate(var(--rotate));
}
</style>