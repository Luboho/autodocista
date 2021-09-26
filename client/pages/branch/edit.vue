<template>
    <div class="img-bg flex img-bg justify-center">
        <div class="pt-32 pb-64">
            <h1 class="text-xl">Upraviť údaje pobočky</h1>

            <form @submit.prevent="submit" class="py-10">

                    <div class="relative">
                        <label for="name" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                            Názov
                        </label>

                        <div>
                            <input id="name"
                                v-model="form.name"
                                @click="clearErrors"
                                type="text" 
                                class="pt-8 pl-3 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
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
                        <label for="email" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                            E-mail
                        </label>

                            <div>
                                <input id="email" 
                                v-model="form.email"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 pl-3 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                                name="email" 
                                size="40"
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
                                class="pt-8 pl-3 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                                name="phone" 
                                size="40"
                                value="" 
                                autocomplete="phone"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.phone ? errors.phone[0] : ''"></p>
        
                        </div>
                    </div>

                    <div class="relative pt-3">
                        <label for="address" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                            Adresa
                        </label>

                            <div>
                                <input id="address" 
                                v-model="form.address"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 pl-3 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                                name="address" 
                                size="40"
                                value="" 
                                autocomplete="address"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.address ? errors.address[0] : ''"></p>
        
                        </div>
                    </div>

                    <div class="relative pt-3">
                        <label for="city" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                            Mesto
                        </label>

                            <div>
                                <input id="city" 
                                v-model="form.city"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 pl-3 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                                name="city" 
                                size="40"
                                value="" 
                                autocomplete="city"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.city ? errors.city[0] : ''"></p>
        
                        </div>
                    </div>

                    <div class="relative pt-3">
                        <label for="postal_code" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                            PSČ
                        </label>

                            <div>
                                <input id="postal_code" 
                                v-model="form.postal_code"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 pl-3 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                                name="postal_code" 
                                size="40"
                                value="" 
                                autocomplete="postal_code"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.postal_code ? errors.postal_code[0] : ''"></p>
        
                        </div>
                    </div>

                    <div class="relative pt-3">
                        <label for="ico" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                            IČO
                        </label>

                            <div>
                                <input id="ico" 
                                v-model="form.ico"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 pl-3 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                                name="ico" 
                                size="40"
                                value="" 
                                autocomplete="ico"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.ico ? errors.ico[0] : ''"></p>
        
                        </div>
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
    import {mapState, mapActions} from 'vuex'

export default {
    name: "branchEdit",
    middleware: 'authenticated',

    data: () => ({
        form: {
            id: "",
            name: "",
            email: "",
            phone: "",
            address: "",
            city: "",
            postal_code: "",
            ico: "",
        },
        errors: []
    }),

    async mounted() {
        await this.getItemForEdit();
    },

    computed: {
        ...mapState({
            notPaginatedBranches: state => state.branches.notPaginatedBranches.data
        })
    },

    methods: {

        ...mapActions({
            getUiMessage: 'uiMessages/getUiMessage'
        }),

         async submit(e) {
            
            try {
                let errors = [];
                await this.$axios.$get('sanctum/csrf-cookie');
                let resp = await this.$axios.patch('/api/branch/edit', {
                    id: this.form.id,
                    name: this.form.name,
                    email: this.form.email,
                    phone: this.form.phone,
                    address: this.form.address,
                    city: this.form.city,
                    postal_code: this.form.postal_code,
                    ico: this.form.ico
                })
                .then((resp) => this.$store.dispatch('uiMessages/getUiMessage', resp.data))
                .then(() => this.$router.replace({path: '/dashboard'}))
            } catch (e) {
                if(e.response.data.errors) {
                    this.errors = e.response.data.errors;
                } else if(e.response.data.message) {
                    this.$store.dispatch('uiMessages/getUiMessage', e.response )
                }
            }
        },

        getItemForEdit() {
            if(this.$route.params.id) {
                let item = this.notPaginatedBranches.filter(item => item.id == this.$route.params.id)
                this.form.id = item[0].id,
                this.form.name = item[0].name;
                this.form.email = item[0].email;
                this.form.phone = item[0].phone;
                this.form.address = item[0].address;
                this.form.city = item[0].city;
                this.form.postal_code = item[0].postal_code;  
                this.form.ico = item[0].ico;
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
  background-image: url('~@/assets/default-images/painting.jpg');
  background-repeat: repeat-y;
  background-position: center;
}
</style>