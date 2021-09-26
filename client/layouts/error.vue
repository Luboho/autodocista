  <template>
  <div class="img-bg min-w-xxs w-screen h-screen bg-gray-800">
    <div class="max-w-7xl h-screen flex justify-center items-center">
      <div class="mb-32">
        <h1 class="text-center text-5xl md:text-7xl"> {{ error.statusCode }}</h1>

        <div class="flex flex-col sm:flex-row justify-center items-baseline">
          <nuxt-link to="/" class="sm:text-center md:text-left mx-auto">
            <font-awesome-icon :icon="['fas', 'home']" class="text-gold-300 text-5xl" />
          </nuxt-link>
          <h2 class="ml-5 md:text-lg text-center">Zdá sa, že stránka ktorú hľadáte nieje k dispozícii. </h2>
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