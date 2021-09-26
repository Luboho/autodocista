<template>
  <div class="img-bg min-w-xxs w-screen h-screen bg-gray-800">
    <div class="max-w-7xl h-screen flex justify-center items-center">
      <div class="mb-32">
        <div class="flex flex-col sm:flex-row justify-center items-baseline">
          <nuxt-link to="/" class="sm:text-center md:text-left mx-auto">
            <font-awesome-icon :icon="['fas', 'home']" class="text-gold-300 text-5xl" />
          </nuxt-link>
          <h3 class="md:text-lg ml-3 text-center">Prepáčte. Táto stránka momentálne nieje k dispozícii. </h3>       
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'reconstraction'
}
</script>

<style scoped>
.img-bg {
  background-image: url('~@/assets/default-images/in_construction.jpg');
  background-repeat: repeat-y;
  background-position: center;
}
</style>