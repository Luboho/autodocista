<template>
<div class="w-full h-full flex justify-items-center justify-center">
  <div class="my-64">
    <Spinner />
  </div>
</div>
</template>

<script>
import {mapMutations} from 'vuex'
import Spinner from './../../../components/Spinner'
  export default {

    async mounted() {
      await this.verify();
      this.spin(true);
    },

    methods: {
      ...mapMutations({
          spin: 'spinner/SET_SPINNER'
      }),

      async verify() {
        const id = this.$route.params.verify.split('-').pop();
        const token = this.$route.params.verify.split('-')[0];
        
        await this.$axios.$get('sanctum/csrf-cookie');

        let resp = await this.$axios.post('/api/verify', {
          token: token,
          id: id
        });

        if (resp.data.data.success == true) {
          this.spin(false);
          this.$router.replace('/auth/login');
        } else {
          alert('You are already been verified, please login.');
          this.spin(false);
          this.$router.replace('/auth/login');
        }
      }
    },

    components: {
      Spinner
    }
  }
</script>;