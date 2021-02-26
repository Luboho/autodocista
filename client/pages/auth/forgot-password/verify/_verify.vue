<template>
  <div>
    <div v-if="notVerified">
      <!-- Spinner -->fdfasdfasdfsdaf
    </div>

    <form @submit.prevent="submit" v-else class="pt-1">
          <div class="font-weight-bold text-xl">
              Nastavte si heslo
          </div>
          <div class="relative pt-3">
              <label for="email" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                  Váš Email
              </label>

                  <div>
                      <input  
                          id="email" 
                          v-model="form.email"
                          type="email" 
                          class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700"
                          name="email" 
                          value="" 
                          disabled
                          autocomplete="email"
                      >
              </div>
          </div>

          <div class="relative pt-3">
              <label for="password" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                  Vaše nové heslo
              </label>

                  <div>
                      <input @click="clearErrors" 
                          id="password" 
                          v-model="form.password"
                          type="password" 
                          class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700"
                          name="password" 
                          value="" 
                          autocomplete="password"
                      >

                  <p class="text-red-600 text-sm" v-text="errors.password ? errors.password[0] : ''"></p>

              </div>
          </div>

          <div class="relative pt-3">
              <label for="password_confirmation" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                  Potvrdiť heslo
              </label>

                  <div>
                      <input @click="clearErrors" 
                          id="password_confirmation" 
                          v-model="form.password_confirmation"
                          type="password" 
                          class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700"
                          name="password_confirmation" 
                          value="" 
                          autocomplete="password_confirmation"
                      >

                  <p class="text-red-600 text-sm" v-text="errors.password_confirmation ? errors.password_confirmation[0] : ''"></p>

              </div>
          </div>

          <div class="pt-8">
              <button type="submit" class="w-full focus:outline-none hover:shadow-xl focus:bg-indigo-700 bg-gray-400 hover:bg-gray-200 py-2 px-3 uppercase rounded text-indigo-700 focus:text-gray-400 font-bold">
                  Uložiť
              </button>
          </div>
      </form>
  </div>
</template>

<script>
  
  export default {

    data: () => ({
            form: {
                password: "",
                email: "",
            },
            notVerified: true,
            errors: []
        }),

    async mounted() {
      await this.verifyForgotten();
    },
    methods: {
      async verifyForgotten() {
        const id = this.$route.params.verify.split('-').pop();
        const token = this.$route.params.verify.split('-')[0];
        
        await this.$axios.$get('sanctum/csrf-cookie');

        let resp = await this.$axios.post('/api/forgot-password-verify', {
          token: token,
          id: id
        });
        
        if (resp.data.data.success == true) {
          // Update Your Password
          this.notVerified = false;
          this.form.email = resp.data.data.email;
        } else {
            alert('Something goes wrong.');
            // Message for user.
          // this.$router.replace({name: 'auth-login'});
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
                    alert('Your password has being changed')
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
  }
</script>;