<template>
    <div class="img-bg flex justify-center ">
            <form @submit.prevent="submit" class="p-10 my-40">
                <h1 class="py-5 text-xl">Kontaktný formulár</h1>
    <!-- Name Input -->
                <div class="relative mx-auto py-6">
                    <label for="name" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                        Meno
                    </label>
                    <div>
                        <input 
                            @click="clearErrors" 
                            id="name" 
                            v-model="form.name"
                            type="name" 
                            class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 text-white outline-none focus:shadow-inner focus:bg-opacity-75 focus:text-gold-500"
                            name="name" 
                            value="" 
                            size="40"
                            autocomplete="name"
                        >

                        <p class="text-red-600 text-sm" v-text="errors.name ? errors.name[0] : ''"></p>

                    </div>
                </div>
    <!-- Email Input -->
                <div class="relative py-6">
                    <label for="email" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                        E-mail &nbsp; *
                    </label>
                        <input @click="clearErrors" 
                            id="email" 
                            v-model="form.email"
                            type="email" 
                            class="pt-8 rounded bg-gray-400 bg-opacity-25 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                            name="email" 
                            value="" 
                            size="40"
                            autocomplete="email"
                        >

                        <p class="text-red-600 text-sm" v-text="errors.email ? errors.email[0] : ''"></p>
                </div>

    <!-- Mobile Num Selection -->
                <div class="relative py-6">
                    <label for="phone" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                        Telefón
                    </label>
                    <input @click="clearErrors" 
                        id="phone" 
                        v-model="form.phone"
                        class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 w-101 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                        name="phone" 
                        value="" 
                        autocomplete="email"
                    >
                        <p class="text-red-600 text-sm" v-text="errors.phone ? errors.phone[0] : ''"></p>
                </div>

    <!-- Branch Selection -->
                <div class="relative py-6">
                    
                    <select name="city" id="" v-model="form.branch_id" class="cursor-pointer w-101 rounded p-5 text-gold-300 text-xs bg-opacity-50 focus:bg-opacity-75 bg-gray-400 outline-none focus:text-gold-500">
                        <option value="" selected="true" disabled="disabled" >
                            <span class="trancking-widest text-xs text-gold-300">Vyberte prevádzku... &nbsp;* </span>
                        </option>
                        <option v-for="branch in branches" :key="branch.id" :value="branch.id" class="bg-gray-400">{{ branch.name }} , {{ branch.city }}</option>
                    </select>
                </div>
    <!-- Message area -->
                <div class="relative py-6">
                    <label for="message" class="absolute tracking-widest text-gold-300 text-xs pl-2 pt-2">
                        Správa &nbsp;*
                    </label>
                    <textarea @click="clearErrors" 
                        id="message" 
                        v-model="form.message"
                        class="pt-8 rounded bg-gray-400 bg-opacity-50 p-2 text-white outline-none focus:bg-opacity-75 focus:text-gold-500"
                        name="message" 
                        rows="3" 
                        cols="41"
                    ></textarea>
                    <p class="text-red-600 text-sm" v-text="errors.message ? errors.message[0] : ''"></p>

                </div>

                <div class="pt-8">
                    <button type="submit" class="border text-sm self-center focus:outline-none hover:shadow-xl focus:bg-gray-400 bg-gold-500 py-2 px-3 uppercase rounded text-gold-900 focus:text-gold-500 hover:bg-gray-400 hover:border-gold-500 hover:text-gold-500 font-bold transition duration-500 ease-in-out transform active:scale-75">
                        Odoslať
                    </button>
                </div>
            </form>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    export default {
        data: () => ({
            form: {
                name: "",
                email: "",
                phone: "",
                branch_id: "",
            },
            errors:[],
        }),

        async fetch(){
            await this.$store.dispatch('branches/getNotPaginatedList');
        },

        computed: {
            ...mapState({
                branches: state => state.branches.notPaginatedBranches.data,
            }),
        },

        methods: {

            async submit(e) {

                try {
                    let errors = [];
                    await this.$axios.$get('sanctum/csrf-cookie');
                    await this.$axios.post('/api/contact-us', {
                        name: this.form.name,
                        email: this.form.email,
                        phone: this.form.phone,
                        branch_id: this.form.branch_id,
                        message: this.form.message
                    }).then(() => console.log)
                      .then(() => this.$router.replace({path: '/'}));
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
  background-image: url('~@/assets/default-images/mercedes1980x1320.jpg');
  background-repeat: repeat-y;
  background-position: center;
}

</style>