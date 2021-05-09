<template>
    <div class="img-bg flex justify-center">

        <div class="pt-44 pb-64">
            <form @submit.prevent="submit" class="pt-24 pb-10">
                        
                <div class="relative">
                    <label for="email" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                        E-mail
                    </label>

                        <div>
                            <input @click="clearErrors" 
                            id="email" 
                            v-model="form.email"
                            type="email" 
                            size="40"
                            class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:text-white"
                            name="email" 
                            value="" 
                            autofocus
                            autocomplete="email"
                        >

                        <p class="text-red-600 text-sm" v-text="errors.email ? errors.email[0] : ''"></p>

                    </div>
                </div>

                <div class="relative pt-3">
                    <label for="password" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                    Heslo
                    </label>

                    <input @click="clearErrors" 
                        id="password" 
                        v-model="form.password"
                        type="password"
                        size="40"
                        class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:text-white"
                        name="password" 
                        autocomplete="new-password">

                    <p class="text-red-600 text-sm" v-text="errors.password ? errors.password[0] : ''"></p>
                    
                </div>

                <div class="pt-8">
                    <button type="submit" class="border self-center focus:outline-none hover:shadow-xl focus:bg-gray-400 bg-gold-500 py-2 px-3 uppercase rounded text-gold-900 focus:text-gold-500 hover:bg-gray-400 hover:border-gold-500 hover:text-gold-500 font-bold">
                        Prihlásiť
                    </button>
                </div>
            </form>

            <div class="py-1">
                <NuxtLink to="/auth/forgot-password/form" class="mt-4 text-sm text-gray-400">Zabudol som heslo <span class="sr-only"></span></NuxtLink>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",

    data: () => ({
        name: [],
        form: {
            email: "",
            password: "",
        },
        errors: []
    }),

    created() {
        this.verifiedEmail();
    },

    methods: {

        async submit(e) {
            try {
                await this.$axios.$get('sanctum/csrf-cookie');
                await this.$auth.loginWith('local', {data: this.form})
                    .then(() => this.$router.replace({path: '/dashboard'}))
            } catch (e) {
                if(e.response.data.errors) {
                    this.errors = e.response.data.errors;
                } else if (e.response.request.status == 401) {
                    this.errors = { email: { 0: 'Nesprávne zadaný email, alebo heslo.'}}
                }
            }
        },

        verifiedEmail() {
            if(this.$route.query.verifiedEmail) {
                this.form.email = this.$route.query.verifiedEmail;
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

    // watchQuery(["auth-forgot-password-verify-verify"]),

    watch: {
        verifiedEmail: function() {

            // this.form.email = $route.query.verifiedEmail;
        }
    }
}
</script>

<style scoped>
.img-bg {
  background-image: url('~@/assets/default-images/login-bg.jpg');
  background-repeat: repeat-y;
  background-position: center;
}
</style>