<template>
    <div class="img-bg flex justify-center">

        <div class="pt-44 pb-64">

            <h1 class="text-xl">Prihlásiť</h1>

            <form @submit.prevent="submit" class="py-10">
                        
                <div class="relative">
                    <label for="email" class="absolute uppercase text-gold-300 text-xs font-bold pl-3 pt-2">
                        E-mail
                    </label>

                        <div>
                            <input @click="clearErrors" 
                            id="email" 
                            v-model="form.email"
                            type="email" 
                            class="pt-8 pl-3 rounded bg-gray-400 w-72 bg-opacity-25 p-2 text-sm text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                            name="email" 
                            value="" 
                            autofocus
                            autocomplete="email"
                        >

                        <p class="text-red-600 text-sm" v-text="errors.email ? errors.email[0] : ''"></p>

                    </div>
                </div>

                <div class="relative pt-3">
                    <label for="password" class="absolute uppercase text-gold-300 text-xs font-bold pl-3 pt-2">
                    Heslo
                    </label>

                    <input @click="clearErrors" 
                        id="password" 
                        v-model="form.password"
                        type="password"
                        class="pt-8 pl-3 rounded bg-gray-400 w-72 bg-opacity-25 p-2 text-sm text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                        name="password" 
                        autocomplete="new-password">

                    <p class="text-red-600 text-sm" v-text="errors.password ? errors.password[0] : ''"></p>
                    
                </div>

                <div class="pt-8">
                    <button type="submit" class="border self-center transition duration-500 ease-in-out transform active:scale-75 focus:outline-none hover:shadow-xl focus:bg-gray-400 bg-gold-500 py-2 px-3 uppercase rounded text-gold-900 focus:text-gold-500 hover:bg-gray-400 hover:border-gold-500 hover:text-gold-500 font-bold">
                        Prihlásiť
                    </button>
                </div>
            </form>

            <div class="py-1 flex justify-between">
                <NuxtLink to="/auth/forgot-password/form" class="mt-4 text-sm text-gray-400 hover:text-gray-300 ">Zabudol som heslo <span class="sr-only"></span></NuxtLink>
                <NuxtLink to="/auth/forgot-password/form" class="mt-4 text-sm text-gray-400 hover:text-gray-300 ">Zmeniť heslo <span class="sr-only"></span></NuxtLink>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    head: {
        title: "Prihlásenie"
    },

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
                await this.$auth.loginWith('laravelSanctum', {data: this.form})
                    .then(() => this.$router.replace({path: '/'}));
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