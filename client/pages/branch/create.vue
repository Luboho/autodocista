<template>
    <div class="img-bg flex justify-center">
        <div class="pt-30 pb-64">
            <h1 class="text-xl">Vytvoriť pobočku</h1>

            <form @submit.prevent="submit" class="py-10">

                    <div class="relative">
                        <label for="name" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                            Názov
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
                                type="text"
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

                    <div class="relative pt-3">
                        <label for="address" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                            Adresa
                        </label>

                            <div>
                                <input id="address" 
                                v-model="form.address"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gray-300 focus:text-white"
                                name="address" 
                                size="40"
                                value="" 
                                autocomplete="address"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.address ? errors.address[0] : ''"></p>
        
                        </div>
                    </div>

                    <div class="relative pt-3">
                        <label for="city" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                            Mesto
                        </label>

                            <div>
                                <input id="city" 
                                v-model="form.city"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gray-300 focus:text-white"
                                name="city" 
                                size="40"
                                value="" 
                                autocomplete="city"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.city ? errors.city[0] : ''"></p>
        
                        </div>
                    </div>

                    <div class="relative pt-3">
                        <label for="postal_code" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                            PSČ
                        </label>

                            <div>
                                <input id="postal_code" 
                                v-model="form.postal_code"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gray-300 focus:text-white"
                                name="postal_code" 
                                size="40"
                                value="" 
                                autocomplete="postal_code"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.postal_code ? errors.postal_code[0] : ''"></p>
        
                        </div>
                    </div>

                    <div class="relative pt-3">
                        <label for="ico" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                            IČO
                        </label>

                            <div>
                                <input id="ico" 
                                v-model="form.ico"
                                type="text"
                                @click="clearErrors"
                                class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gray-300 focus:text-white"
                                name="ico" 
                                size="40"
                                value="" 
                                autocomplete="ico"
                            >

                            <p class="text-red-600 text-sm" v-text="errors.ico ? errors.ico[0] : ''"></p>
        
                        </div>
                    </div>
                
                    <div class="pt-8">
                        <button type="submit" class="border self-center focus:outline-none hover:shadow-xl focus:bg-gray-400 bg-gold-500 py-2 px-3 uppercase rounded text-gold-900 focus:text-gold-500 hover:bg-gray-400 hover:border-gold-500 hover:text-gold-500 font-bold">
                            Uložiť
                        </button>
                    </div>
            </form>
        </div>
    </div>
</template>

<script>

export default {
    name: "branchCreate",
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

    methods: {
         async submit(e) {
            
            try {
                let errors = [];
                await this.$axios.$get('sanctum/csrf-cookie');
                let resp = await this.$axios.post('/api/branch/create', {
                    id: this.form.id,
                    name: this.form.name,
                    email: this.form.email,
                    phone: this.form.phone,
                    address: this.form.address,
                    city: this.form.city,
                    postal_code: this.form.postal_code,
                    ico: this.form.ico
                }).then((resp) => this.$store.dispatch('uiMessages/getUiMessage', resp.data));
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
/* .img-bg {
  background-image: url('~@/assets/default-images/reg-bg.jpg');
  background-repeat: repeat-y;
  background-position: center;
} */
</style>