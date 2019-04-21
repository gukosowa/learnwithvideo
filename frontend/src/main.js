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

//* ApolloClient
import VueApollo from 'vue-apollo'
Vue.use(VueApollo)
import { ApolloClient } from 'apollo-client'
import { HttpLink } from 'apollo-link-http'
import { InMemoryCache } from 'apollo-cache-inmemory'
// HTTP connexion to the API
const httpLink = new HttpLink({
  // You should use an absolute URL here
  uri: 'http://127.0.0.1:8000/graphql',
})
// Cache implementation
const cache = new InMemoryCache()
// Create the apollo client
const apolloClient = new ApolloClient({
  debug: true,
  link: httpLink,
  cache,
})
const apolloProvider = new VueApollo({
  defaultClient: apolloClient,
})

//* New Line
import Nl2br from 'vue-nl2br'
Vue.component('nl2br', Nl2br)

//* Autosize Input
import VueInputAutowidth from 'vue-input-autowidth'
Vue.use(VueInputAutowidth)

Vue.config.productionTip = false

window.vue = new Vue({
  router,
  store,
  apolloProvider,
  render: h => h(App)
}).$mount('#app')
