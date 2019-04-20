<template>
  <div style="transition-duration:0.2s;" class="header h-12 bg-gray-700 flex flex-row items-center shadow-md z-30"
  		:style="(!showHeader) ? 'height:2rem; min-height:1rem; background-color: rgb(40, 50, 67);' : 'min-height:2.5rem; background-color: #4a5568;'">
	<img style="transition-duration:0.1s;" src="@/assets/img/logo.svg" width="35px" class="ml-10" 
	     :style="(!showHeader) ? 'transform: scale(0.6, 0.6) translate(-50%,0); opacity:0.3;' : ''"/>
	<span style="transition-duration:0.3s;" class="font-normal text-gray-100 text-md ml-4"
	:style="(!showHeader) ? 'transform: scale(0.6, 0.6) translate(-50%,0); opacity:0;' : ''">Learn with Video</span>

	<div class="right-0 mr-10 flex flex-row absolute float-right items-center">
	  <input id="navSearch" style="transition-duration:0.2s;" :class="{ 'shadow appearance-none border rounded w-full py-1 px-3 text-grey-400 tracking-wider font-light focus:outline-none focus:shadow-outline' : showHeader, 'shadow appearance-none rounded border py-1 px-2 text-grey-400 tracking-wider font-light :outline-none' : !showHeader }"
	  		 :style="(!showHeader) ? 'transform: scale(0.6, 0.6) translate(43.6%, 0px); background-color: rgba(131, 131, 131, 0.3); border: 0px;' : ''"
	  		type="text" placeholder="Search videos">

	  <div class="">
		<img style="transition-duration:0.2s;" src="@/assets/img/settings.svg" width="30px" class="ml-5" 
				:style="(!showHeader) ? 'transform: scale(0.6, 0.6) rotate(-50deg); opacity:0.4;' : ''"/>
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

		vm.onOutWait = true;
		setTimeout(function() {
			vm.showHeader = false;
		}, vm.timeoutHide + 1000);

		window.addEventListener("mousemove", function(e) {
			if (e.y <= 50) {
				vm.showHeader = true;
				vm.onOutWait = false;
			} else {
				if (vm.onOutWait == false) {
					if (e.y >= 90) {
						vm.onOutWait = true;
						setTimeout(function() {
							vm.showHeader = false;
							vm.navSearch.blur();
						}, vm.timeoutHide);
					}
				}
			}
		});
	},

	methods: {
	},
}
</script>

<style scoped>

</style>