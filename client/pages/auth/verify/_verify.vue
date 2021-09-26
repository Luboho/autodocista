<template>
<div class="w-screen h-screen flex ">
  <div class="h-screen w-screen flex justify-center items-center -mt-20">
    <div class="">
      <Spinner />
    </div>
  </div>
</div>
</template>

<script>
import {mapMutations, mapActions} from 'vuex'
import Spinner from './../../../components/Spinner'
  export default {

     mounted() {
        this.$store.dispatch('spinner/setSpinner', true);
        this.verify();
    },

    methods: {
      ...mapMutations({
          spin: 'spinner/SET_SPINNER'
      }),
      ...mapActions({
          setSpinner: 'spinner/setSpinner',
      }),

      async verify() {
        const id = this.$route.params.verify.split('-').pop();
        const token = this.$route.params.verify.split('-')[0];
        await this.$axios.$get('sanctum/csrf-cookie');

        let resp = await this.$axios.post('/api/verify', {
          token: token,
          id: id
        }).then((resp) => {
          if(resp.data.data.success) {
            this.$store.dispatch('uiMessages/getUiMessage', resp.data);
          } else {
            this.$store.dispatch('uiMessages/getUiMessage', resp.data);
          }
        }).then((resp) => {
          this.$store.dispatch('spinner/setSpinner', false);
          this.$router.replace('/auth/login');
        });
      }
    },

    components: {
      Spinner,
    }
  }
</script>;