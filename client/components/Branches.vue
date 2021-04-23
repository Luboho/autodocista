<template>
<div>
    <h2 class="text-gold-500 py-2 uppercase">Naše pobočky</h2>
    <!-- Small Device -->
    <div v-if="smallDevice">
        <div v-for="branch in branches" :key="branch.id">
            <div class="text-gray-300 rounded-sm border p-2 mb-1 border-black transition delay-700 duration-500 ease-in">
                <div class="flex justify-between">

                    <div class="flex flex-col">
                        <p class=" text-gray-100">Kontakt: </p>
                            <p class="ml-2 text-gray-500 font-semibold first:text-gray-800">
                                 {{ branch.name }}
                            <br>
                                <a :href="'mailto:' + branch.email">{{ branch.email }}</a>
                            <br>
                                <a :href="'tel:' + branch.phone">{{ branch.phone }}</a> 
                            </p>
                    </div>
                    
                    <div class="flex flex-col">
                        <p class="text-gray-100">Mesto:  </p> 
                            <p class="ml-2 text-gray-800 font-semibold">
                                {{ branch.city }}                                
                            </p>
                    </div>
                </div>

                    <p class="text-gray-100">Adresa:  </p>
                        <div class="text-gray-500 font-semibold ml-2">
                            {{ branch.address }}
                        </div>
                    <p class=" text-gray-100">Vytvorená: </p>
                        <p class="ml-2 text-gray-500 font-semibold"> 
                            {{ branch.created_at }}
                        </p>
             </div>
        </div>
    </div>

    <!-- Bigger Devices -->
    <div v-else>

        <table class="my-5 mx-auto bg-gray-400 py-8 table-fixed">
            <thead class="text-gray-100">
                <tr>
                    <th class="text-center w-3/12 py-2">Kontakt</th>
                    <th class="text-center w-3/12">Mesto</th>
                    <th class="text-center w-5/12">Adresa</th>
                    <th class="text-center w-1/12">Vytvorená</th>
                </tr>
            </thead>
            <tbody v-for="branch in branches" :key="branch.id">
                <tr class="text-gray-200 rounded-xl border-2 border-black transition delay-700 duration-500 ease-in">
                    <td class="w-3/12 pl-2 first:text-gray-800">
                        <span class="text-gray-600 font-bold">
                            {{ branch.name }}
                        </span>    
                            <br>
                        <a :href="'mailto:' + branch.email">{{ branch.email }}</a>
                            <br>
                        <a :href="'tel:' + branch.phone">{{ branch.phone }}</a>
                    </td>
                    <td class="text-center w-3/12 text-gray-800 font-semibold">{{ branch.city }}</td>
                    <td class="text-center w-5/12">{{ branch.address }}</td>
                    <td class="text-center w-1/12 pr-1">{{ branch.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-if="branches">
        <Pagination store="branches" collection="branches" />
    </div>
</div>
</template>

<script>    
import {mapState} from 'vuex'
import Spinner from './Spinner'
import Pagination from './Pagination'

export default {
    name: "Branches",

    data: () => ({
        smallDevice: true,
    }),


    computed: {
        ...mapState({
            branches: state => state.branches.branches.data,
            loading: state => state.loading
        }),
    },

    async mounted() {
        await this.$store.dispatch('branches/getList', 0),

        this.fitTableByDeviceWidth();

        window.onresize = () => {
            if (window.innerWidth < 768){
                this.smallDevice = true;
            } else {
                this.smallDevice = false;
            }
        };
    },

    methods: {

        // ...mapActions(['deleteBranch']),

        fitTableByDeviceWidth() {
            if (window.innerWidth < 768){
                this.smallDevice = true;
            } else {
                this.smallDevice = false;
            }
        },
    },

    components: {
        Spinner,
        Pagination
    }
}
</script>
