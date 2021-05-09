<template>
    <div class="img-bg flex justify-center">
        <div class="pt-44 pb-64">

            <form @submit.prevent="submit" class="py-24 pb-10">

                    <div class="relative">
                        <label for="name" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                            Meno
                        </label>

                        <div>
                            <input id="name"
                                v-model="form.name"
                                @click="clearErrors"
                                type="text" 
                                class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:text-white"
                                name="name" 
                                size="40"
                                value="" 
                                autocomplete="name"
                                autofocus
                            >

                            <p class="text-red-600 text-sm" v-text="errors.name ? errors.name[0] : ''"></p>

                        </div>
                    </div>
                    
                    <div class="relative pt-3">
                        <label for="email" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                            E-mail
                        </label>

                            <div>
                                <input id="email" 
                                v-model="form.email"
                                type="email"
                                @click="clearErrors"
                                class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gray-300 focus:text-white"
                                name="email" 
                                size="40"
                                value="" 
                                autocomplete="email"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.email ? errors.email[0] : ''"></p>
        
                        </div>
                    </div>

                    <div class="relative pt-3">
                        <label for="phone" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                            Telefón
                        </label>

                            <div>
                                <input id="phone" 
                                v-model="form.phone"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gray-300 focus:text-white"
                                name="phone" 
                                size="40"
                                value="" 
                                autocomplete="phone"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.phone ? errors.phone[0] : ''"></p>
        
                        </div>
                    </div>

    <!-- Branch Selection -->
                    <div class="relative pt-3">
                        <select name="branch" id="" v-model="form.branch_id"  class=" border border-gold-500 rounded w-44 p-5  hoverBg text-gold-500 bg-opacity-50 bg-gray-400 outline-none focus:text-gold-500">
                            <option value="" selected="true" disabled="disabled">Vyberte prevádzku...*</option>
                            <option v-for="branch in branches" 
                                    :key="branch.id" 
                                    :value="branch.id" 
                                    class="bg-gray-400"
                            >
                                {{ branch.name }}
                            </option>
                        </select>
                    </div>

                    <div class="relative pt-3">
                        <select name="is_admin" id="" v-model="form.is_admin"  class=" border border-gold-500 rounded w-44 p-5  hoverBg text-gold-500 bg-opacity-50 bg-gray-400 outline-none focus:text-gold-500">
                            <option value="" selected="true" disabled="disabled">Vyberte oprávnenie užívateľa...*</option>
                            <option value='0'
                                    class="bg-gray-400"
                            >
                                Užívateľ
                            </option>
                            <option value='1'
                                    class="bg-gray-400"
                            >
                                Admin
                            </option>
                        </select>
                    </div>

                    <div class="relative pt-3">
                        <label for="password" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                        Heslo
                        </label>

                        <input id="password" 
                            v-model="form.password"
                            @click="clearErrors"
                            type="password" 
                            class="pt-8 rounded w-44 bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gray-300 focus:text-white"
                            name="password" 
                            size="40"
                            autocomplete="new-password">

                        <p class="text-red-600 text-sm" v-text="errors.password ? errors.password[0] : ''"></p>

                    </div>


                    <div class="relative pt-3">    
                        <label for="password-confirm" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                            Potvrdiť heslo
                        </label>

                        <input id="password-confirm" 
                                @click="clearErrors"
                                v-model="form.password_confirmation"
                                type="password" 
                                class="pt-8 rounded w-44 bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gray-300 focus:text-white"
                                name="password_confirmation" 
                                size="40"
                                autocomplete="new-password">

                        <p class="text-red-600 text-sm" v-text="errors.password_confirmation ? errors.password_confirmation[0] : ''"></p>

                    </div>
                
                    <div class="pt-8">
                        <button type="submit" class="border self-center focus:outline-none hover:shadow-xl focus:bg-gray-400 bg-gold-500 py-2 px-3 uppercase rounded text-gold-900 focus:text-gold-500 hover:bg-gray-400 hover:border-gold-500 hover:text-gold-500 font-bold">
                            Registrovať
                        </button>
                    </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

export default {
    name: "Register",

    data: () => ({
        form: {
            name: "",
            email: "",
            phone: "",
            branch_id: "",
            is_admin: '',
            password: "",
            password_confirmation: ""
        },
        errors: []
    }),

    computed: {
            ...mapState({
                branches: state => state.branches.branches
            }),
    },

    methods: {
         async submit(e) {
            
            try {
                let errors = [];
                await this.$axios.$get('sanctum/csrf-cookie');
                await this.$axios.post('/api/register', {
                    name: this.form.name,
                    email: this.form.email,
                    phone: this.form.phone,
                    branch_id: this.form.branch_id,
                    is_admin: this.form.is_admin,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation,
                }).then(function() {
                    alert('Na váš email bol odoslaný odkaz. Prosím potvrďte ho.')
                })
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

<style scoped>
.img-bg {
  background-image: url('~@/assets/default-images/reg-bg.jpg');
  background-repeat: repeat-y;
  background-position: center;
}
</style>