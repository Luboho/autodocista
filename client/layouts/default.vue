<template>
  <div class="bg-gray-800 overflow-x-hidden mr-auto ml-auto ">
    <div class="ml-auto mr-auto max-w-7xl min-w-xxs">
      <Navbar />
      <UiMessages />
      <Modal />
      <Nuxt />
      <div class="absolute">
        <font-awesome-icon @click="share = !share" :icon="['fas', 'share-alt']" class="cursor-pointer hover:text-gold-500 tranform transition duration-500 ease-in-out transform active:scale-75 text-5xl border-1 hover:border-gold-300 rounded-xl p-2 w-16 h-auto text-gray-200 m-4 fixed z-40 bottom-0 "  />
        <div v-if="share" class="ml-16 slide">
            <SocialSharing />
        </div>
      </div>
      <Footer />

    </div>
  </div>
</template>

<script>
  import Navbar from './Nav/Navbar';
  import UiMessages from '../components/UiMessages';
  import Footer from './Footer';
  import Modal from './../components/Modal.vue';
  import SocialSharing from './../components/SocialSharing.vue'


  export default {
    head: {
      title: "Autodočista - rozmaznávajte svoje auto",
      titleTemplate: '%s - Autodočista',
      meta: [
        {
          hid: 'og:type',
          property: 'og:type',
          content: 'article'
        },
        {
          hid: 'og:title',
          property: 'og:title',
          content: 'Autodočista. Pre vaše auto to najlepšie.'
        },
        {
          hid: 'og:description',
          property: 'og:description',
          content: 'Eaque eius autem facilis omnis dignissimos officia eligendi unde beatae laudantium, cupiditate nam molestiae numquam perspiciatis veniam '
        },
        {
          hid: 'og:image',
          property: 'og:image',
          content: `${process.env.baseUrl +'/shared-images/swift.jpg'}`
        },
        {
          hid: 'og:image:secure_url',
          property: 'og:image:secure_url',
          content: `${process.env.baseUrl +'/shared-images/swift.jpg'}`
        },
      ]
    },
    data: () => ({
      share: false,
    }),

    transition: "fade",

    components: {
      Navbar,
      Modal,
      UiMessages,
      Footer,
      SocialSharing
    }
  }
</script>
<style>
  .slide {
  animation-duration: 0.8s;
  animation-name: slidein;
}
@keyframes slidein {
  from {
    margin-left: 5000px;
  }

  to {
    margin-left: 65px;
  }
}
</style>
