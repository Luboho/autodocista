<template>
    <div>
        <form @submit.prevent="submit" class="pt-1">

                <div class="relative">
                    <label for="name" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">
                        Meno
                    </label>

                    <div>
                        <input id="name"
                               v-model="form.name"
                               @click="clearErrors"
                               type="text" 
                               class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700" 
                               name="name" 
                               value="" 
                               autocomplete="name" autofocus>

                        <p class="text-red-600 text-sm" v-text="errors.name ? errors.name[0] : ''"></p>

                    </div>
                </div>
                
                <div class="relative pt-3">
                    <label for="email" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                        E-mail
                    </label>

                        <div>
                            <input id="email" 
                               v-model="form.email"
                               type="email"
                               @click="clearErrors"
                               class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700"
                               name="email" 
                               value="" 
                               autocomplete="email"
                               placeholder="imejl@email.sk">

                        <p class="text-red-600 text-sm" v-text="errors.email ? errors.email[0] : ''"></p>
    
                    </div>
                </div>

                <div class="relative pt-3">
                    <label for="city" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                        Mesto
                    </label>

                    <div>
                        <input id="city" 
                            v-model="form.city"
                            type="text"
                            @click="clearErrors"
                            class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700"
                            name="city" 
                            value="" 
                            autocomplete="city"
                            >

                        <p class="text-red-600 text-sm" v-text="errors.city ? errors.city[0] : ''"></p>

                    </div>
                </div>

                <div class="relative pt-3">
                    <label for="password" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                       Heslo
                    </label>

                    <input id="password" 
                           v-model="form.password"
                           @click="clearErrors"
                           type="password" 
                           class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700" 
                           name="password" 
                           autocomplete="new-password">

                    <p class="text-red-600 text-sm" v-text="errors.password ? errors.password[0] : ''"></p>

                </div>


                <div class="relative pt-3">    
                    <label for="password-confirm" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                           Potvrdiť heslo
                    </label>

                    <input id="password-confirm" 
                            @click="clearErrors"
                            v-model="form.password_confirmation"
                            type="password" 
                            class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700" 
                            name="password_confirmation" 
                            autocomplete="new-password">

                    <p class="text-red-600 text-sm" v-text="errors.password_confirmation ? errors.password_confirmation[0] : ''"></p>

                </div>
            
                <div class="pt-8">
                    <button type="submit" class="w-full focus:outline-none hover:shadow-xl focus:bg-indigo-700 bg-gray-400 hover:bg-gray-200 py-2 px-3 uppercase rounded text-indigo-700 focus:text-gray-400 font-bold">
                        Registrovať
                    </button>
                </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "Register",

    data: () => ({
        form: {
            name: "",
            email: "",
            city: "",
            password: "",
            password_confirmation: ""
        },
        errors: []
    }),

    methods: {
         async submit(e) {
            
            try {
                let errors = [];
                await this.$axios.$get('sanctum/csrf-cookie');
                await this.$axios.post('/api/register', {
                    name: this.form.name,
                    email: this.form.email,
                    city: this.form.city,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation,
                }).then(function() {
                    alert('You received a confirmation email. Please verify your email.')
                })
                // try {
                //     await this.$auth.loginWith('local', {
                //         data: {
                //             email: this.form.email,
                //             password: this.form.password
                //         }
                //     }).then(res => console.log(res))
                // } catch (e) {
                //     console.log(e);
                // }
                this.$router.replace({name: 'index'})
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