<template>
  <form @submit.prevent="submit" class="pt-1">
                
                <div class="relative pt-3">
                    <label for="email" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                        E-mail
                    </label>

                        <div>
                            <input @click="clearErrors" 
                               id="email" 
                               v-model="form.email"
                               type="email" 
                               class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700"
                               name="email" 
                               value="" 
                               autocomplete="email"
                               placeholder="imejl@email.sk">

                        <p class="text-red-600 text-sm" v-text="errors.email ? errors.email[0] : ''"></p>

                    </div>
                </div>

                <div class="relative pt-3">
                    <label for="password" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                       Heslo
                    </label>

                    <input @click="clearErrors" 
                           id="password" 
                           v-model="form.password"
                           type="password" 
                           class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700" 
                           name="password" 
                           autocomplete="new-password">

                    <p class="text-red-600 text-sm" v-text="errors.password ? errors.password[0] : ''"></p>
                    
                </div>

                <div class="pt-8">
                    <button type="submit" class="w-full focus:outline-none hover:shadow-xl focus:bg-indigo-700 bg-gray-400 hover:bg-gray-200 py-2 px-3 uppercase rounded text-indigo-700 focus:text-gray-400 font-bold">
                        Prihlásiť
                    </button>
                </div>
            
        </form>
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

    methods: {

        async submit(e) {
            try {
                await this.$axios.$get('sanctum/csrf-cookie');
                await this.$auth.loginWith('local', {data: this.form})
            } catch (e) {
                if(e.response.data.errors) {
                    this.errors = e.response.data.errors;
                } else if (e.response.request.status == 401) {
                    this.errors = { email: { 0: 'Nesprávne zadaný email, alebo heslo.'}}
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

</style>