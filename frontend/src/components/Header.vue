<template>
  <div class="header h-12 bg-gray-700 flex flex-row items-center shadow-md z-30">
	<div class="relative" style="display:contents;">
		<img src="@/assets/img/logo2.svg" height="48px" class="header-img ml-10">
		<span class="absolute header-text text-white font-hairline">BIDEO</span>
	</div>
	<div ref="headerElement" class="right-0 mr-10 flex flex-row absolute float-right items-center">
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
        distanceToHeaderElement: 1000,
		}
	},

	mounted() {
		this.navSearch = document.getElementById("navSearch");
		
		var vm = this;

		// vm.onOutWait = true;
		// setTimeout(function() {
		// 	vm.showHeader = false;
        // }, vm.timeoutHide + 1000);
        console.log(vm.$refs.headerElement);

		window.addEventListener("mousemove", function(e) {
            vm.distanceToHeaderElement = calculateDistance(vm.$refs.headerElement, e.pageX, e.pageY);

			vm.animateHeader(vm.distanceToHeaderElement);
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
			var start = 5;
			var end = 32;

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
							to: '#07070d',      
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
							from: 0.4,            
							to: 0.2,            
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
							from: 101,              
							to: 0,              
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
							from: 0.43,            
							to: 0,            
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
							to: 100,            
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
							from: 0.8,            
							to: 0,            
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
function calculateDistance(elem, mouseX, mouseY) {
    var x = 0;
    var y = 0;
    if (!elem) {
        return 1000;
    }
    if (mouseX < elem.offsetLeft) {
        x = Math.pow((mouseX + elem.offsetWidth/2) - (elem.offsetLeft+(elem.offsetWidth/2)), 2);
    } else if (mouseX > elem.offsetLeft + elem.offsetWidth) {
        x = Math.pow((mouseX - elem.offsetWidth/2) - (elem.offsetLeft+(elem.offsetWidth/2)), 2);
    }
    if (mouseY < elem.offsetTop) {
        y = Math.pow((mouseY + elem.offsetHeight / 2) - (elem.offsetTop+(elem.offsetHeight/2)), 2);
    } else if (mouseY > elem.offsetTop + elem.offsetHeight) {
        y = Math.pow((mouseY - elem.offsetHeight / 2) - (elem.offsetTop+(elem.offsetHeight/2)), 2);
    }
	return Math.floor(Math.sqrt(x + y));
}
</script>

<style scoped>
.header {
	--height: 1rem;
	--color: #1a202c;
	height: var(--height);
	min-height: var(--height);
    background-color: var(--color);
    
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25'%3E%3Cdefs%3E%3ClinearGradient id='a' gradientUnits='userSpaceOnUse' x1='0' x2='0' y1='0' y2='100%25' gradientTransform='rotate(141,840,458)'%3E%3Cstop offset='0' stop-color='%2307070d'/%3E%3Cstop offset='1' stop-color='%230a141f'/%3E%3C/linearGradient%3E%3Cpattern patternUnits='userSpaceOnUse' id='b' width='453' height='377.5' x='0' y='0' viewBox='0 0 1080 900'%3E%3Cg fill-opacity='0.02'%3E%3Cpolygon fill='%23444' points='90 150 0 300 180 300'/%3E%3Cpolygon points='90 150 180 0 0 0'/%3E%3Cpolygon fill='%23AAA' points='270 150 360 0 180 0'/%3E%3Cpolygon fill='%23DDD' points='450 150 360 300 540 300'/%3E%3Cpolygon fill='%23999' points='450 150 540 0 360 0'/%3E%3Cpolygon points='630 150 540 300 720 300'/%3E%3Cpolygon fill='%23DDD' points='630 150 720 0 540 0'/%3E%3Cpolygon fill='%23444' points='810 150 720 300 900 300'/%3E%3Cpolygon fill='%23FFF' points='810 150 900 0 720 0'/%3E%3Cpolygon fill='%23DDD' points='990 150 900 300 1080 300'/%3E%3Cpolygon fill='%23444' points='990 150 1080 0 900 0'/%3E%3Cpolygon fill='%23DDD' points='90 450 0 600 180 600'/%3E%3Cpolygon points='90 450 180 300 0 300'/%3E%3Cpolygon fill='%23666' points='270 450 180 600 360 600'/%3E%3Cpolygon fill='%23AAA' points='270 450 360 300 180 300'/%3E%3Cpolygon fill='%23DDD' points='450 450 360 600 540 600'/%3E%3Cpolygon fill='%23999' points='450 450 540 300 360 300'/%3E%3Cpolygon fill='%23999' points='630 450 540 600 720 600'/%3E%3Cpolygon fill='%23FFF' points='630 450 720 300 540 300'/%3E%3Cpolygon points='810 450 720 600 900 600'/%3E%3Cpolygon fill='%23DDD' points='810 450 900 300 720 300'/%3E%3Cpolygon fill='%23AAA' points='990 450 900 600 1080 600'/%3E%3Cpolygon fill='%23444' points='990 450 1080 300 900 300'/%3E%3Cpolygon fill='%23222' points='90 750 0 900 180 900'/%3E%3Cpolygon points='270 750 180 900 360 900'/%3E%3Cpolygon fill='%23DDD' points='270 750 360 600 180 600'/%3E%3Cpolygon points='450 750 540 600 360 600'/%3E%3Cpolygon points='630 750 540 900 720 900'/%3E%3Cpolygon fill='%23444' points='630 750 720 600 540 600'/%3E%3Cpolygon fill='%23AAA' points='810 750 720 900 900 900'/%3E%3Cpolygon fill='%23666' points='810 750 900 600 720 600'/%3E%3Cpolygon fill='%23999' points='990 750 900 900 1080 900'/%3E%3Cpolygon fill='%23999' points='180 0 90 150 270 150'/%3E%3Cpolygon fill='%23444' points='360 0 270 150 450 150'/%3E%3Cpolygon fill='%23FFF' points='540 0 450 150 630 150'/%3E%3Cpolygon points='900 0 810 150 990 150'/%3E%3Cpolygon fill='%23222' points='0 300 -90 450 90 450'/%3E%3Cpolygon fill='%23FFF' points='0 300 90 150 -90 150'/%3E%3Cpolygon fill='%23FFF' points='180 300 90 450 270 450'/%3E%3Cpolygon fill='%23666' points='180 300 270 150 90 150'/%3E%3Cpolygon fill='%23222' points='360 300 270 450 450 450'/%3E%3Cpolygon fill='%23FFF' points='360 300 450 150 270 150'/%3E%3Cpolygon fill='%23444' points='540 300 450 450 630 450'/%3E%3Cpolygon fill='%23222' points='540 300 630 150 450 150'/%3E%3Cpolygon fill='%23AAA' points='720 300 630 450 810 450'/%3E%3Cpolygon fill='%23666' points='720 300 810 150 630 150'/%3E%3Cpolygon fill='%23FFF' points='900 300 810 450 990 450'/%3E%3Cpolygon fill='%23999' points='900 300 990 150 810 150'/%3E%3Cpolygon points='0 600 -90 750 90 750'/%3E%3Cpolygon fill='%23666' points='0 600 90 450 -90 450'/%3E%3Cpolygon fill='%23AAA' points='180 600 90 750 270 750'/%3E%3Cpolygon fill='%23444' points='180 600 270 450 90 450'/%3E%3Cpolygon fill='%23444' points='360 600 270 750 450 750'/%3E%3Cpolygon fill='%23999' points='360 600 450 450 270 450'/%3E%3Cpolygon fill='%23666' points='540 600 630 450 450 450'/%3E%3Cpolygon fill='%23222' points='720 600 630 750 810 750'/%3E%3Cpolygon fill='%23FFF' points='900 600 810 750 990 750'/%3E%3Cpolygon fill='%23222' points='900 600 990 450 810 450'/%3E%3Cpolygon fill='%23DDD' points='0 900 90 750 -90 750'/%3E%3Cpolygon fill='%23444' points='180 900 270 750 90 750'/%3E%3Cpolygon fill='%23FFF' points='360 900 450 750 270 750'/%3E%3Cpolygon fill='%23AAA' points='540 900 630 750 450 750'/%3E%3Cpolygon fill='%23FFF' points='720 900 810 750 630 750'/%3E%3Cpolygon fill='%23222' points='900 900 990 750 810 750'/%3E%3Cpolygon fill='%23222' points='1080 300 990 450 1170 450'/%3E%3Cpolygon fill='%23FFF' points='1080 300 1170 150 990 150'/%3E%3Cpolygon points='1080 600 990 750 1170 750'/%3E%3Cpolygon fill='%23666' points='1080 600 1170 450 990 450'/%3E%3Cpolygon fill='%23DDD' points='1080 900 1170 750 990 750'/%3E%3C/g%3E%3C/pattern%3E%3C/defs%3E%3Crect x='0' y='0' fill='url(%23a)' width='100%25' height='100%25'/%3E%3Crect x='0' y='0' fill='url(%23b)' width='100%25' height='100%25'/%3E%3C/svg%3E");
    background-attachment: fixed;
    background-size: cover;
}
.header-img {
	--opacity: 0.3;
	--scale: 0.6;
	--xTranslate: 0;
	transform-origin: 0% 56%;
	opacity: var(--opacity);
	transform: scale(var(--scale), var(--scale)) translate(var(--xTranslate),0);
}
.header-text {
	--opacity: 0;
	--scale: 0.43;
    --xTranslate: -50%;
    transform-origin: 0% 50%;
    -webkit-text-stroke: 28.45px rgba(0, 0, 0, -0.9);
	letter-spacing: 1.6rem;
	font-size: 21.7px;
	opacity: var(--opacity);
	transform: scale(var(--scale), var(--scale)) translate(var(--xTranslate),139%);
}
.header-search {
	--color: #8383834d;
	--opacity: 0.3;
	--scale: 0.6;
	opacity: var(--opacity);
	transform-origin: 100% 53%;
	transform: scale(1, var(--scale));
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