<template>
<div class="w-full h-full flex justify-items-center justify-center">
  <div class="my-64">
    <Spinner :loading="loading" />
  </div>
</div>
</template>

<script>
import Spinner from './../../../components/Spinner'
  export default {

    data: () => ({
        loading: true
    }),

    async mounted() {
      await this.verify();
    },

    methods: {
      async verify() {
        const id = this.$route.params.verify.split('-').pop();
        const token = this.$route.params.verify.split('-')[0];
        
        await this.$axios.$get('sanctum/csrf-cookie');

        let resp = await this.$axios.post('/api/verify', {
          token: token,
          id: id
        });

        if (resp.data.data.success == true) {
          this.loading = false;
          this.$router.replace('/auth/login');
        } else {
          alert('You are already been verified, please login.');
          this.loading = false;
          this.$router.replace('/auth/login');
        }
      }
    },

    components: {
      Spinner
    }
  }
</script>;