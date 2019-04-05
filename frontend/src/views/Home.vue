<template>
  <div class="container">
    <div class="home flex flex-col">
      <img alt="Vue logo" src="../assets/logo.png" class="object-contain mt-3">
      <p class="text-center block text-blue-500 mt-3 font-bold">Initial vue, tailwind, laravel release</p>

      <div class="video-container flex flex-col mt-10">
        <youtube class="self-center" 
        ref="youtube"
        :player-vars="{ autoplay: 1, controls: 0, showinfo: 0 }" 
        :video-id="url"
        @ready="ready" 
        @paused="paused" 
        @playing="playing"
        ></youtube>
        <div class="bg-red-500 w-full h-2" v-bind:style="{ width: progress + '%' }"></div>
      </div>

      <p>{{ time }}</p>
    </div>
  </div>
</template>

<script>

export default {
  name: 'home',
  data () {
    return {
      time: "00:00",
      progress: 0,
      processId: null,
      duration: "asdasd",
      url: "8ulEMXUNyRo"
    }
  },
  computed: {
    ply() {
      return this.$refs.youtube;
    },
  },
  methods: {
    method (url) {
      this.videoId = this.$youtube.getIdFromURL(url)
      this.startTime = this.$youtube.getTimeFromURL(url)
    },
    ready (event) {
      this.player = event.target
    },
    change () {
      // when you change the value, the player will also change.
      // If you would like to change `playerVars`, please change it before you change `videoId`.
      // If `playerVars.autoplay` is 1, `loadVideoById` will be called.
      // If `playerVars.autoplay` is 0, `cueVideoById` will be called.
      this.videoId = 'another video id'
    },
    // eslint-disable-next-line
    async playing(event) {
      console.log(this.$refs.youtube.player.getDuration());
      let totalTime = await this.ply.player.getDuration();

      this.processId = setInterval(() => {
        if (this.ply.player) {
          let time = this.ply.player.getCurrentTime();
          let progress = (time / totalTime) * 100;

          this.progress = progress < 100 ? progress : 100;
          console.log(progress);
          this.updateTime(time + 1);
        }
        
        // this.ply.player.getCurrentTime().then((time) => {
        //   let progress = (time / totalTime) * 100;

        //   this.progress = progress < 100 ? progress : 100;
        //   this.updateTime(time + 1);
        // });
      }, 10);
    },
    updateTime(time) {
      time = Math.round(time);
      let minutes = Math.floor(time / 60);
      let seconds = time - minutes * 60;

      seconds = seconds < 10 ? '0' + seconds : seconds;
      minutes = minutes < 10 ? '0' + minutes : minutes;

      this.time = minutes + ':' + seconds;
    },
    stop () {
      this.player.stopVideo()
    },
    pause () {
      this.player.pauseVideo()
    },
    paused() {
      clearInterval(this.processId);
    }
  },
}

</script>