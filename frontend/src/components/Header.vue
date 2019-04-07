<template>
  <div class="header h-12 bg-gray-700 flex flex-row items-center shadow-md z-30">
    <img src="@/assets/img/logo.svg" width="35px" class="ml-10" />
    <span class="font-normal text-gray-100 text-md ml-4">Learn with Video</span>

    <div class="right-0 mr-10 flex flex-row absolute float-right items-center">
      <input class="shadow appearance-none border rounded w-full py-1 px-3 text-grey-400 tracking-wider font-light focus:outline-none focus:shadow-outline" 
      id="username" type="text" placeholder="Search videos">

      <div class="">
        <img src="@/assets/img/settings.svg" width="30px" class="ml-5" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Header',
}
</script>

<style scoped>

</style>