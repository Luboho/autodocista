<template>
  <div class="bg-gray-800 min-w-xxs">
    <div class="max-w-7xl mx-auto ">
      <Navbar />
      <UiMessages />
      <Modal />
      <Nuxt />
      <Footer />
    </div>
  </div>
</template>

<script>
  import Navbar from './Nav/Navbar';
  import UiMessages from '../components/UiMessages';
  import Footer from './Footer';
  import Modal from './../components/Modal.vue';

  export default {
    transition: "fade",

    components: {
      Navbar,
      Modal,
      UiMessages,
      Footer,
    }
  }
</script>
<style>
  /* .appear-enter-active, .appear-leave-active { transition: opacity .5s; }
  .appear-enter, .appear-leave-active { opacity: 0; } */
</style>
