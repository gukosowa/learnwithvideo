import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

//* VueYouTubeEmbed
import VueYouTubeEmbed from 'vue-youtube-embed'
Vue.use(VueYouTubeEmbed, { global: true, componentId: "youtube" })

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
