<template>
<div>
    <h2 class="text-gold-500 py-2 uppercase">Registrovaní užívatelia</h2>
    <div class="absolute w-full flex justify-center">
        <Spinner :loading="loading" />
    </div>
    <!-- Small Device -->
    <div v-if="smallDevice">

        <div v-for="user in users" :key="user.id">

            <!-- Message iter. -->
            <div class="text-gray-200 rounded-sm border p-2 mb-1 border-black transition delay-700 duration-500 ease-in"
            >
                <div class="flex justify-between">

                    <div class="flex flex-col">
                        <p class=" text-gray-100">Meno a kontakt: </p>
                            <p class="ml-2 text-gray-700">
                                {{ user.name }}
                                    <br>
                                <a :href="'mailto:' + user.email ">{{ user.email }}</a>
                                    <br >
                                <a :href="'tel:' + user.phone ">{{ user.phone }}</a>
                            </p>
                    </div>
                    
                    <div class="flex flex-col">
                        <p class="text-gray-100">Pracuje:  </p> 
                            <p class="ml-2 text-gray-700">
                                {{ user.branch.name }}                                
                            </p>
                    </div>
                </div>

                    <p v-show="authUser.role == 'admin'" 
                       class="text-gray-100"
                       :class="{'text-gray-600' : user.role == 'admin'}"
                    >Registrovaný ako:
                            {{ user.role }}
                    </p>
                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-100">Vytvorený: </p>
                                <p class="ml-2 text-gray-700"> 
                                    {{ user.created_at }}
                                </p>
                        </div>
                        <div>
                            <p>
                                &nbsp;
                            </p>
                            <a href="#" 
                               v-show="authUser.role == 'admin'"  
                               class="text-2xl font-black mr-2 text-red-800 hover:text-red-600">
                                x 
                            </a>
                        </div>
                    </div>
             </div>
        </div>
    </div>

    <!-- Bigger Devices -->
    <div v-else>

        <table class="my-5 mx-auto bg-gray-400 py-8 table-fixed">
            <thead class=" text-gray-100">
                <tr>
                    <th class="text-center w-4/12 py-2">Meno a kontakt</th>
                    <th class="text-center w-4/12">Pracuje</th>
                    <th v-show="authUser.role == 'admin'" class="text-center w-2/12">Registrovaný ako</th>
                    <th class="text-center w-3/12">Vytvorený</th>
                    <th class="text-center w-1/12"></th>
                </tr>
            </thead>
            <tbody v-for="user in users" :key="user.id">
                <tr class="text-gray-200 rounded-xl border-2 border-black transition delay-700 duration-500 ease-in">
                    <td class="w-3/12 pl-2">
                        {{ user.name }}
                            <br>
                        <a :href="'mailto:' + user.email ">{{ user.email }}</a>
                            <br >
                        <a :href="'tel:' + user.phone ">{{ user.phone }}</a>
                    </td>
                    <td class="text-center w-4/12">{{ user.branch.name }}</td>
                    <td v-show="authUser.role == 'admin'"
                        class="text-center w-2/12"
                        :class="{'text-gray-600 font-semibold' : user.role == 'admin'}">
                       {{ user.role }}
                    </td>
                    <td class="text-center w-3/12">{{ user.created_at }}</td>
                    <td>
                        <a href="#" 
                            v-show="authUser.role == 'admin'"  
                            class="text-2xl font-black mr-2 align-items-middle text-red-800 hover:text-red-600">
                            x 
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>    
import {mapState} from 'vuex'
import Spinner from './Spinner'

export default {
    name: "Users",

    data: () => ({
        smallDevice: true,
    }),

    computed: {
        ...mapState({
            users: state => state.users.users,
            authUser: state => state.auth.user,
            loading: state => state.users.loading
        }),
    },

    beforeMount() {
    
        this.fitTableByDeviceWidth();

        window.onresize = () => {
            if (window.innerWidth < 768){
                this.smallDevice = true;
            } else {
                this.smallDevice = false;
            }
        }        
    },

    async mounted() {
        await this.$store.dispatch('users/getUsers')
    },

    methods: {

        fitTableByDeviceWidth() {
            if (window.innerWidth < 768){
                this.smallDevice = true;
            } else {
                this.smallDevice = false;
            }
        }
    },

    components: {
        Spinner
    }
}
</script>