<template>
  <div class="loading-spinner flex items-center justify-center font-body">
    <video
      class="h-36 w-36"
      autoplay
      loop
      muted
      playsinline
    >
      <source src="../../assets/videos/chef.mp4" type="video/mp4" />
    </video>
  </div>
</template>

<script setup>
</script>

<style scoped>
.loading-spinner {
  min-height: 100px;
}
</style>
