<template>
    <div class="img-bg flex justify-center">
        <div class="pt-44 pb-64">

            <form @submit.prevent="submit" class="py-24 pb-10">

                    <div class="relative">
                        <label for="name" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                            Meno
                        </label>

                        <div>
                            <input id="name"
                                v-model="form.name"
                                @click="clearErrors"
                                type="text" 
                                class="pt-8 pl-3 rounded bg-gray-400 w-72 bg-opacity-25 p-2 text-sm text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                                name="name" 
                                value="" 
                                autocomplete="name"
                                autofocus
                            >

                            <p class="text-red-600 text-sm" v-text="errors.name ? errors.name[0] : ''"></p>

                        </div>
                    </div>
                    
                    <div class="relative pt-3">
                        <label for="email" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                            E-mail
                        </label>

                            <div>
                                <input id="email" 
                                v-model="form.email"
                                type="email"
                                @click="clearErrors"
                                disabled="disabled"
                                class="pt-8 pl-3 rounded bg-gray-400 w-72 bg-opacity-25 p-2 text-sm text-gray-300 outline-none focus:bg-opacity-75 focus:text-gold-500 cursor-not-allowed "
                                name="email" 
                                value="" 
                                autocomplete="email"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.email ? errors.email[0] : ''"></p>
        
                        </div>
                    </div>

                    <div class="relative pt-3">
                        <label for="phone" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                            Telefón
                        </label>

                            <div>
                                <input id="phone" 
                                v-model="form.phone"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 pl-3 rounded bg-gray-400 w-72 bg-opacity-25 p-2 text-sm text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                                name="phone" 
                                value="" 
                                autocomplete="phone"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.phone ? errors.phone[0] : ''"></p>
        
                        </div>
                    </div>

    <!-- Branch Selection -->
                    <div class="relative pt-3">
                        <select name="branch" id="" v-model="form.branch_id" class="cursor-pointer border border-gold-500 tracking-widest rounded w-72 p-5 hoverBg text-xs text-gold-300 bg-opacity-50 bg-gray-400 outline-none focus:text-gold-500">
                            
                            <option :value="form.id" selected="true">{{ form.branch }}</option>
                            <option v-for="branch in branches" 
                                    :key="branch.id" 
                                    :value="branch.id" 
                                    class="bg-gray-400"
                            >
                                {{ branch.name }}
                            </option>
                        </select>
                    </div>

                    <!-- <div class="relative pt-3">
                        <select name="is_admin" id="" v-model="form.is_admin"  class=" border border-gold-500 rounded w-72 p-5  hoverBg text-gold-500 bg-opacity-50 bg-gray-400 outline-none focus:text-gold-500">
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
                    </div> -->

                    <div class="relative pt-3">
                        <label for="password" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                        Heslo
                        </label>

                        <input id="password" 
                            v-model="form.password"
                            @click="clearErrors"
                            type="password" 
                            class="pt-8 pl-3 rounded bg-gray-400 w-72 bg-opacity-25 p-2 text-sm text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                            name="password" 
                            autocomplete="new-password">

                        <p class="text-red-600 text-sm" v-text="errors.password ? errors.password[0] : ''"></p>

                    </div>


                    <div class="relative pt-3">    
                        <label for="password-confirm" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                            Potvrdiť heslo
                        </label>

                        <input id="password-confirm" 
                                @click="clearErrors"
                                v-model="form.password_confirmation"
                                type="password" 
                                class="pt-8 pl-3 rounded bg-gray-400 w-72 bg-opacity-25 p-2 text-sm text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                                name="password_confirmation" 
                                autocomplete="new-password">

                        <p class="text-red-600 text-sm" v-text="errors.password_confirmation ? errors.password_confirmation[0] : ''"></p>

                    </div>
                
                    <div class="pt-8">
                        <button type="submit" class="border self-center transition duration-500 ease-in-out transform active:scale-75 focus:outline-none hover:shadow-xl focus:bg-gray-400 bg-gold-500 py-2 px-3 uppercase rounded text-gold-900 focus:text-gold-500 hover:bg-gray-400 hover:border-gold-500 hover:text-gold-500 font-bold">
                            Uložiť
                        </button>
                    </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

export default {
    name: "authEdit",
    middleware: 'authenticated',

    data: () => ({
        form: {
            id: "",
            name: "",
            email: "",
            phone: "",
            branch: "",
            branch_id: "",
            is_admin: '',
            password: "",
            password_confirmation: ""
        },
        errors: [],
    }),

    async mounted() {
        await this.getItemForEdit();
    },

    computed: {
        ...mapState({
            branches: state => state.branches.notPaginatedBranches.data,
            allUsers: state => state.users.allUsers.data
        }),
    },

    methods: {
         async submit(e) {
            
            try {
                let errors = [];
                await this.$axios.$get('sanctum/csrf-cookie');
                let resp = await this.$axios.patch('/api/users/edit', {
                    id: this.form.id,
                    name: this.form.name,
                    phone: this.form.phone,
                    branch_id: this.form.branch_id,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation,
                })
                .then((resp) => this.$store.dispatch('uiMessages/getUiMessage', resp.data))
                .then(() => this.$router.replace({path: '/dashboard'}))
            } catch (e) {
                if(e.response.data.errors) {
                    this.errors = e.response.data.errors;
                    this.$router.replace({path: '/'});
                }
            }
        },

        getItemForEdit() {
            if(this.$route.params.id) {
                let item = this.allUsers.filter(item => item.id == this.$route.params.id)
                this.form.id = item[0].id,
                this.form.branch = item[0].branch.name;
                this.form.branch_id = item[0].branch_id;
                this.form.name = item[0].name;
                this.form.email = item[0].email;
                this.form.phone = item[0].phone;
            } else {
                console.log('MIssing $route.params')
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