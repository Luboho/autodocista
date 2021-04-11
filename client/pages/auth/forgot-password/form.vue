<template>
    <div class="img-bg">


        <div class="flex justify-center">
            <div class="py-64">
            <div class="font-weight-bold text-gold-500">
                Zabudnuté heslo
            </div>

                <form @submit.prevent="submit" class="pt-10 pb-10">
                            
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

                    <div class="pt-8">
                        <button type="submit" class="border self-center focus:outline-none hover:shadow-xl focus:bg-gray-400 bg-gold-500 py-2 px-3 uppercase rounded text-gold-900 focus:text-gold-500 hover:bg-gray-400 hover:border-gold-500 hover:text-gold-500 font-bold">
                            Odoslať
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</template>

<script>
    export default {
        data: () => ({
            name: [],
            form: {
                email: "",
            },
            errors: []
        }),

        methods: {
            async submit(e) {
            
                try {
                    let errors = [];
                    await this.$axios.$get('sanctum/csrf-cookie');
                    await this.$axios.post('/api/forgot-password', {
                        email: this.form.email,
                    }).then(function() {
                        alert('You received a confirmation email. Please verify your email.')
                    })
                    
                    // this.$router.replace({name: 'index'})
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
        }
    }
</script>

<style>
.img-bg {
  background-image: url('~@/assets/default-images/forgotten_password.jpg');
  background-repeat: repeat-y;
  background-position: center;
}
</style>