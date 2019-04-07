<template>
  <div id="app" class="w-full h-full flex flex-col font-sans subpixel-antialiased">
    <Header/>
    <router-view/>
  </div>
</template>

<script>
import Header from "@/components/Header"

export default {
  components: {
    Header
  },
  data() {
    return {
    }
  }
}
</script>

<style>
  html, body {
    width:100%;
    height:100%;
  }
</style>

<style src="./assets/css/main.css"></style>

