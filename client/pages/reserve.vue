<template>
    <div class="img-bg flex justify-center ">
            <form @sumbit.prevent="submit" class="p-10 my-40">
                <h1 class="py-5 text-xl">Rezervačný formulár</h1>
    <!-- Name Input -->
                <div class="relative mx-auto py-6">
                    <label for="name" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                        Meno
                    </label>
                    <div>
                        <input 
                            @click="clearErrors" 
                            id="name" 
                            v-model="form.name"
                            type="name" 
                            class="pt-8 rounded w-44 bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gray-300 focus:text-gray-800"
                            name="name" 
                            value="" 
                            size="30"
                            autocomplete="name"
                            placeholder="Karol Vysoký">

                        <!-- <p class="text-red-600 text-sm" v-text="errors.name ? errors.name[0] : ''"></p> -->

                    </div>
                </div>
    <!-- Email Input -->
                <div class="relative py-6">
                    <label for="email" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                        E-mail
                    </label>
                        <input @click="clearErrors" 
                            id="email" 
                            v-model="form.email"
                            type="email" 
                            class="pt-8 rounded w-72 bg-gray-400 bg-opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gray-300 focus:text-gray-800"
                            name="email" 
                            value="" 
                            size="30"
                            autocomplete="email"
                            placeholder="imejl@email.sk">

                        <!-- <p class="text-red-600 text-sm" v-text="errors.email ? errors.email[0] : ''"></p> -->
                </div>

    <!-- Time Selection -->
                <div class="relative py-6">
                    <label for="email" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                        Vyberte čas
                    </label>
                    <input type="time" 
                        name="time" 
                        id=""
                        class="w-44 border border-gold-500 rounded bg-gray-400 bg-opacity-50 p-4 text-white outline-none focus:bg-gray-300 focus:text-gray-800">
                </div>

    <!-- City Selection -->
                <div class="relative py-6">
                    
                            <select name="city" id="" v-model="form.name"  class=" border border-gold-500 rounded w-44 p-5  hoverBg text-gold-500 bg-opacity-50 bg-gray-400 outline-none focus:text-gold-500">
                                <option value="" selected="true" disabled="disabled">Vyberte prevádzku...</option>
                                <option v-for="branch in branches" :key="branch.id" class="bg-gray-400">{{ branch.city }} , {{ branch.address }}</option>
                                <!-- <option value="banska-bystrica-bordyho-2" class="bg-gray-400">Banská Bystrica, Bordyho 2</option>
                                <option value="kosice-bernolakova-6" class="bg-gray-400">Košice, Bernoláková 6</option>
                                <option value="kosice-janosikova-2" class="bg-gray-400">Košice, Jánošíková 2</option>
                                <option value="bratislava-dunajska-22" class="bg-gray-400">Bratislava, Dunajská 22</option>
                                <option value="presov-kosicka-5" class="bg-gray-400">Prešov, Košická 5</option> -->
                            </select>
                </div>

                <div class="pt-8">
                    <button type="submit" class="border self-center focus:outline-none hover:shadow-xl focus:bg-gray-400 bg-gold-500 py-2 px-3 uppercase rounded text-gold-900 focus:text-gold-500 hover:bg-gray-400 hover:border-gold-500 hover:text-gold-500 font-bold">
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
                city: "",
                time: ""
            },
            errors:[]
        }),

        computed: {
            ...mapState({
                branches: state => state.branches.branches
            }),
        },

        methods: {
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