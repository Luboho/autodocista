<template>
  <div class="bg-gray-800">
    <div class="max-w-7xl mx-auto">
      <Navbar />
      <Nuxt />
      <Footer />
    </div>
  </div>
</template>

<script>
  import Navbar from './Nav/Navbar';
  import Footer from './Footer';

  export default {

    components: {
      Navbar,
      Footer
    }
  }
</script>
<style>

</style>
