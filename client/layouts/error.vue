<template>
<div class="bg-gray-800">
  <div class="max-w-7xl">
    <div class="w-screen img-bg  ">
      <nuxt-link to="/">
        <font-awesome-icon :icon="['fas', 'home']" class="m-4 text-gold-500 text-5xl" />
      </nuxt-link>
      <div class="flex justify-center items-center h-screen w-screen">
        <div>
          <h1 class="text-5xl md:text-7xl"> {{ error.statusCode }}</h1>
          <p class="md:text-lg">Zdá sa, že stránka ktorú hľadáte nieje k dispozícii. </p>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  name: "error",

  layout: 'error-layout',

  props: {
    error: {
      type: Object,
      default: null
    },
  }
}
</script>

<style scoped>
.img-bg {
  background-image: url('~@/assets/default-images/wrong.jpg');
  background-repeat: repeat-y;
  background-position: center;
}
</style>