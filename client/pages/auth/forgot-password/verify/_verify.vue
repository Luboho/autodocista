<template>
  <div class="flex justify-center pt-44 pb-64">

    <form @submit.prevent="submit">
          <h1>
              Nastavte si heslo
          </h1>
          <div class="relative pt-3">
              <label for="email" class="absolute uppercase text-gold-300 text-xs font-bold pl-3 pt-2">
                  Váš Email
              </label>

                <div>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="pt-8 pl-3 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                        size="40"
                        name="email"
                        value=""
                        disabled
                        autocomplete="email"
                    >
              </div>
          </div>

          <div class="relative pt-3">
              <label for="password" class="absolute uppercase text-gold-300 text-xs font-bold pl-3 pt-2">
                  Vaše nové heslo
              </label>

                <div>
                    <input @click="clearErrors"
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="pt-8 pl-3 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                        size="40"
                        name="password"
                        value=""
                        autocomplete="password"
                    >

                    <p class="text-red-600 text-sm" v-text="errors.password ? errors.password[0] : ''"></p>

              </div>
          </div>

          <div class="relative pt-3">
              <label for="password_confirmation" class="absolute uppercase text-gold-300 text-xs font-bold pl-3 pt-2">
                  Potvrdiť heslo
              </label>

                  <div>
                        <input @click="clearErrors"
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            class="pt-8 pl-3 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                            size="40"
                            name="password_confirmation"
                            value=""
                            autocomplete="password_confirmation"
                        >

                        <p class="text-red-600 text-sm" v-text="errors.password_confirmation ? errors.password_confirmation[0] : ''"></p>

                    </div>
          </div>

          <div class="pt-8">
              <button type="submit" class="border self-center text-sm transition duration-500 ease-in-out transform active:scale-75 focus:outline-none hover:shadow-xl focus:bg-gray-400 bg-gold-500 py-2 px-3 uppercase rounded text-gold-900 focus:text-gold-500 hover:bg-gray-400 hover:border-gold-500 hover:text-gold-500 font-bold">
                  Uložiť
              </button>
          </div>
      </form>
  </div>
</template>

<script>
  import Spinner from './../../../../components/Spinner.vue';
  import {mapActions} from 'vuex'

  export default {

    data: () => ({
            form: {
                password: "",
                email: "",
            },
            notVerified: true,
            errors: []
        }),

    beforeMount() {
        this.setSpinner(true);
    },

    async mounted() {
        await this.verifyForgotten();
    },
    methods: {
        ...mapActions({
            setSpinner: 'spinner/setSpinner',
        }),

        async verifyForgotten() {
            this.setSpinner(false);
            const id = this.$route.params.verify.split('-').pop();
            const token = this.$route.params.verify.split('-')[0];

            await this.$axios.$get('sanctum/csrf-cookie');

            var resp = await this.$axios.post('/api/forgot-password-verify', {
            token: token,
            id: id
            });
                this.$store.dispatch('uiMessages/getUiMessage',  resp.data);

            if (resp.data.data.success) {
            // Update Your Password
                this.form.email = resp.data.data.email;
                this.notVerified = false;
            }
      },

      async submit(e) {

          try {
              let errors = [];
              await this.$axios.$get('sanctum/csrf-cookie');
              await this.$axios.post('/api/reset-password', {
                  email: this.form.email,
                  password: this.form.password,
                  password_confirmation: this.form.password_confirmation,
              }).then(function() {
                    this.$store.dispatch('uiMessages/getUiMessage',  {data: {success: 'Vaše heslo bolo zmenené'}});
              }).then(() => this.$router.replace({path: '/auth/login', query: {verifiedEmail: this.form.email}}))

          } catch (e) {
              if(e.response.data.errors) {
                  this.errors = e.response.data.errors;
              }
          }
      },

      clearErrors(e) {
          if(this.errors) {
              setTimeout(() => {
              const fieldName = [e.target.name][0];
              this.errors[fieldName] = "";
              }, 1000);
          }
      },
    },

    Components: {
        Spinner,
    }
  }
</script>;