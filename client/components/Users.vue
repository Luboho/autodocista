<template>
<div> 
    
    <h2 class="text-gold-500 py-2 uppercase">Registrovaní užívatelia</h2>
    <div class="absolute w-full flex justify-center">
        <div v-if='loading'>
            <Spinner :loading="loading" />
        </div>
    </div>
     <!-- Confirm Item destroying -->
        <div v-if="modal" class="flex justify-center items-center absolute w-full">  <!-- If modal is true SHOW -->
            <div class="fixed text-white rounded-lg z-30 p-8 bg-gray-800">
                <p>Ste si istý, že chcete zmazať záznam? 
                </p>
                <!-- <p v-show="userForDestroy" class="text-gold-500 font-bold">
                    {{ userForDestroy }}
                </p> -->

                <div class="flex items-center mt-6 justify-end">               <!-- Set modal to opposite to HIDE modal-->
                    <button @click="setModal(false)" class="text-white pr-4">Zrušiť</button>
                    <button @click="confirmDeletion" class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white">Zmazať</button>
                </div>
            </div>
        </div> 
     <!--End of Confirm Item destroying -->

    <!-- Small Devices -->
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

                    <p v-show="authUser.is_admin == '1'" 
                       class="text-gray-100"
                    >Registrovaný ako:
                            <span :class="user.is_admin == 'Admin' ? 'text-gold-500 font-bold ml-1' : 'text-gold-300 ml-1' ">{{ user.is_admin }}</span>
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
                            <button 
                                v-show="authUser.is_admin == '1'"  
                                @click="destroy(user.id)"
                                class="text-2xl font-black mr-2 focus:outline-none align-items-middle text-red-800 hover:text-red-600">
                                x 
                            </button>
                        </div>
                    </div>
             </div>
        </div>
    </div>
    <!-- End of Small Devices -->
          

    <!-- Bigger Devices -->
    <div v-else>

        <table class="my-5 mx-auto bg-gray-400 py-8 table-fixed">
            <thead class=" text-gray-100">
                <tr>
                    <th class="w-4/12 py-2">Meno a kontakt</th>
                    <th class="text-center w-4/12">Pracuje pre</th>
                    <th v-show="authUser.is_admin == '1'" class="text-center w-2/12">Registrovaný ako</th>
                    <th class="text-center w-3/12">Vytvorený</th>
                    <th class="text-center w-1/12"></th>
                </tr>
            </thead>
            <tbody v-for="user in users" :key="user.id">
                <tr class="text-gray-200 rounded-xl border-2 border-black transition delay-700 duration-500 ease-in">
                    <td class="w-3/12 pl-2">
                        <span class="text-gray-600 font-bold">
                            {{ user.name }}
                        </span> 
                            <br>
                        <a :href="'mailto:' + user.email ">{{ user.email }}</a>
                            <br >
                        <a :href="'tel:' + user.phone ">{{ user.phone }}</a>
                    </td>
                    <td class="text-center w-4/12 text-gray-600 font-bold">{{ user.branch.name }}</td>
                    <td v-show="authUser.is_admin == '1'"
                        class="text-center w-2/12"
                        :class="user.is_admin == 'Admin' ? 'text-gold-500 font-bold' : 'text-gold-300'">
                       {{ user.is_admin }}
                    </td>
                    <td class="text-center w-3/12">{{ user.created_at }}</td>
                    <td>
                        <button 
                            v-show="authUser.is_admin == '1'"  
                            @click="destroy(user.id)"
                            class="text-2xl font-black mr-2 focus:outline-none align-items-middle text-red-800 hover:text-red-600">
                            x 
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Modal />
    <!-- End of Bigger Devices -->

    <!-- Modal -->
    <!-- <transition name="fade">
        <div v-if="modal" @click="modal = ! modal" class="fixed flex items-center justify-center bg-opacity-50 bg-black z-20 top-0 left-0 right-0 bottom-0"></div>
    </transition> -->
    <!-- End of Modal -->
    <div v-if="users">
        <Pagination store="users" collection="users" />
    </div>
</div>
</template>

<script>    
import {mapState, mapActions, mapMutations} from 'vuex'
import Spinner from './Spinner'
import Modal from './Modal'
import Pagination from './Pagination'

export default {
    name: "Users",

    data: () => ({
        destroyId: '',
        smallDevice: true,
    }),

    computed: {
        ...mapState({
            users: state => state.users.users.data,
            authUser: state => state.auth.user,
            modal: state => state.modal.modal,
            loading: state => state.loading.loading
        }),
        userForDestroy() {
            const destroyName = this.users.filter(user => user.id == this.destroyId);
            return destroyName[0].name;
        }
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
        this.setLoading(true)
        await this.$store.dispatch('users/getList', 0)
    },


    methods: {
        ...mapMutations({
             setModal : 'modal/setModal',
             setLoading: 'loading/setLoading'
        }),
        ...mapActions({
            deleteUser: 'users/deleteUser',
            getList: 'users/getList'
        }),

        destroy(id){
            this.setModal(true);
            this.destroyId = id;
        },
        confirmDeletion() {
            this.setModal(false);
            this.deleteUser(this.destroyId);
            this.destroyId = '';
        },

        fitTableByDeviceWidth() {
            if (window.innerWidth < 768){
                this.smallDevice = true;
            } else {
                this.smallDevice = false;
            }
        }
    },

    components: {
        Spinner,
        Modal,
        Pagination
    }
}
</script>

<style>
@keyframes showModal {
     0% { opacity: 0; }
    100% { opacity: 1; }
}
@keyframes move {
  0% {
    transform: scale(0.9) translateY(100px);
  }
  50% {
    transform: scale(1.05) translateY(-3px);
  }
  100% {
    transform: scale(1.0) translateY(0);
  }
}
/* Category btn */
.fade-enter-active {
    animation: showModal .4s;
}

.fade-leave-active {
    animation: showModal .4s reverse;
}


</style>