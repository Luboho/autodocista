<template>
  <div class="fixed z-50 right-0 left-0 flex justify-center">
    <div v-if="spin">
        <div class="spring-spinner relative">
          <div class="spring-spinner-part top">
              <div class="spring-spinner-rotator"></div>
          </div>
          <div class="spring-spinner-part bottom">
              <div class="spring-spinner-rotator"></div>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
import {mapState} from 'vuex'
import Modal from './Modal'
export default {
  name: "Spinner",

  computed: {
    ...mapState({
        spin: state => state.spinner.spin,
    })
  },
  
  components: {
    Modal
  }

}
</script>

<style>
.spring-spinner, .spring-spinner * {
      box-sizing: border-box;
    }

    .spring-spinner {
      height: 60px;
      width: 60px;
    }

    .spring-spinner .spring-spinner-part {
      overflow: hidden;
      height: calc(60px / 2);
      width: 60px;
    }

    .spring-spinner  .spring-spinner-part.bottom {
       transform: rotate(180deg) scale(-1, 1);
     }

    .spring-spinner .spring-spinner-rotator {
      width: 60px;
      height: 60px;
      border: calc(60px / 7) solid transparent;
      border-right-color: #fde047;
      border-top-color: #fdf7f9;
      border-radius: 50%;
      box-sizing: border-box;
      animation: spring-spinner-animation 3s ease-in-out infinite;
      transform: rotate(-200deg);
    }

    @keyframes spring-spinner-animation {
      0% {
        border-width: calc(60px / 7);
      }
      25% {
        border-width: calc(60px / 23.33);
      }
      50% {
        transform: rotate(115deg);
        border-width: calc(60px / 7);
      }
      75% {
        border-width: calc(60px / 23.33);
      }
      100% {
        border-width: calc(60px / 7);
      }
    }
</style>