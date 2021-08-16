<template>
  <div class="bg-gray-800">
    <div class="max-w-7xl mx-auto">
      <Navbar />
      <UiMessages />
      <Nuxt />
      <Footer />
    </div>
  </div>
</template>

<script>
  import Navbar from './Nav/Navbar';
  import UiMessages from '../components/UiMessages';
  import Footer from './Footer';

  export default {

    components: {
      Navbar,
      UiMessages,
      Footer
    }
  }
</script>
<style>

</style>
