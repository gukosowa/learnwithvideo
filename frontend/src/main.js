import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

//* VueYouTubeEmbed
import VueYouTubeEmbed from 'vue-youtube-embed'
Vue.use(VueYouTubeEmbed, { global: true, componentId: "youtube" })

//* Vue Slider
import VueSlider from 'vue-slider-component'
// import 'vue-slider-component/theme/default.css'
Vue.component('VueSlider', VueSlider)

//* Axios
import axios from 'axios'
Vue.prototype.$http = axios;

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
