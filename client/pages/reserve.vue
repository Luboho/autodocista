<template>
<div class=" w-full img-bg mb-10">
    <div>
        <form class="w-screen p-1 ">
            <div class="relative mx-auto pt-3">
                <label for="name" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                    Meno
                </label>
                <div>
                    <input 
                        @click="clearErrors" 
                        id="name" 
                        v-model="form.name"
                        type="name" 
                        class="pt-10rounded bg-gray-400 opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gold-500 focus:text-gray-800"
                        name="name" 
                        value="" 
                        autocomplete="name"
                        placeholder="Karol Vysoký">

                    <!-- <p class="text-red-600 text-sm" v-text="errors.name ? errors.name[0] : ''"></p> -->

                </div>
            </div>

            <div class="relative pt-3">
                <label for="email" class="absolute uppercase text-gold-500 text-xs font-bold pl-3 pt-2">
                    E-mail
                </label>
                <div class="w-screen">
                    <input @click="clearErrors" 
                        id="email" 
                        v-model="form.email"
                        type="email" 
                        class="pt-8 rounded w-44 bg-gray-400 opacity-50 p-2 border border-gold-500 text-white outline-none focus:bg-gold-500 focus:text-gray-800"
                        name="email" 
                        value="" 
                        autocomplete="email"
                        placeholder="imejl@email.sk">

                    <!-- <p class="text-red-600 text-sm" v-text="errors.email ? errors.email[0] : ''"></p> -->

                </div>
            </div>

            <div class="p-4">
                <input type="time" 
                       name="time" 
                       id=""
                       class="border border-gold-500 bg-gray-500 bg-opacity-50 p-4">
            </div>

            <select name="city" id="" class="border-gold-500 bg-opacity-50">
                <option value="" disabled="disabled">Vyberte si prevádzku...</option>
                <option value="banska-bystrica-bordyho-2">Banská Bystrica, Bordyho 2</option>
                <option value="kosice-bernolakova-6">Košice, Bernoláková 6</option>
                <option value="kosice-janosikova-2">Košice, Jánošíková 2</option>
                <option value="bratislava-dunajska-22">Bratislava, Dunajská 22</option>
                <option value="presov-kosicka-5">Prešov, Košická 5</option>
            </select>

        </form>
    </div>

</div>
</template>

<script>
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

<style>
.img-bg {
  background-image: url('~@/assets/default-images/mercedes1920x1280.jpg');
  background-repeat: repeat-y;
  background-position: center;

}

.width {
    width: 220px;
}
</style>