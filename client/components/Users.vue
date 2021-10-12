<template>
<div> 
    <div class="">
        <div class="flex justify-between m-2">
            <h2 class="text-gold-500 mt-4 mb-6 uppercase">Registrovaní užívatelia</h2>
            <div v-show="authUser.is_admin == '1'" class="flex justify-end items-center">
                <span class="text-gray-300">Pridať</span>
                <NuxtLink to="/auth/register"
                    class="text-gold-400 text-2xl ml-2 mr-1 active:text-gold-700 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none"
                >
                    <font-awesome-icon :icon="['fas', 'plus']" />
                </NuxtLink>
            </div>
        </div>
        <FilterNav store="users" 
                @sortByUnread = "filter.sortByUnread = $event" 
                @filterByCategory = "filter.filterByCategory = $event"
                :dataList="users"
                :allUsers="allUsers" />
    </div>

    <Spinner />

     <!-- Confirm Item destroying -->
        <div v-if="confirm && modal" class="flex justify-center items-center absolute w-full">  <!-- If modal is true SHOW -->
            <div class="fixed text-white rounded-lg z-50 p-8 bg-gray-800">
                <p>Ste si istý, že chcete zmazať záznam  
                </p>
                <p v-show="userForDestroy" class="text-gold-500 font-bold">
                    {{ userForDestroy[0].name }} ?
                </p>

                <div class="flex items-center mt-6 justify-end">               <!-- Set modal to opposite to HIDE modal-->
                    <button @click="cancelDeletion" class="text-white pr-4 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none">Zrušiť</button>
                    <button @click="confirmDeletion" class="px-4 py-2 bg-red-500 rounded text-sm font-bold transition duration-500 ease-in-out transform active:scale-75 focus:outline-none text-white">Zmazať</button>
                </div>
            </div>
        </div> 
     <!--End of Confirm Item destroying -->


    <!-- Small Devices -->
    <div v-if="smallDevice">
        <div v-for="user in users" :key="user.id" class="even:bg-warmGray-300 rounded-md m-3 mx-auto w-full odd:bg-warmGray-400">

            <div class="text-gray-200 border-0.5 p-2 mb-1 border-black transition delay-700 duration-500 ease-in">
                <div class="flex flex-col">

                    <div class="flex flex-col sm:flex-row ">
                        <div class="flex flex-col">
                            <p class="text-gray-800 font-bold">Pracuje:  </p> 
                            <p @click.prevent="showBranch(user.branch.id, $event)" class="ml-2 text-gray-600 hover:text-gray-900 cursor-pointer hover:font-bold">
                                {{ user.branch.name }}                                
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <p class=" text-gray-800 font-bold">Meno a kontakt: </p>
                                <p class="ml-2 text-gray-700">
                                    {{ user.name }}
                                        <br>
                                    <a :href="'mailto:' + user.email" class="hover:font-bold">{{ user.email }}</a>
                                        <br >
                                    <a :href="'tel:' + user.phone" class="hover:font-bold">{{ user.phone }}</a>
                                </p>
                        </div>

                    </div>

                    <p v-show="authUser.is_admin == '1'" 
                       class="text-gray-800 font-bold"
                    >Registrovaný ako:
                            <span :class="user.role == 'Admin' ? 'text-gold-100 font-bold ml-1' : 'text-gold-200 font-light ml-1' ">{{ user.role }}</span>
                    </p>

                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-800 font-bold">Vytvorený: </p>
                            <p class="ml-2 text-gray-700"> 
                                {{ user.created_at }}
                            </p>
                        </div>
                        <div>
                            <p>
                                &nbsp;
                            </p>
                            <NuxtLink :to="{ name: 'auth-edit', params: { id: user.id }}" v-show="authUser.is_admin == '1'">
                            <font-awesome-icon :icon="['fas', 'pencil-alt']"  class="mr-3 text-gray-500 hover:text-gray-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none rounded"/>
                            </NuxtLink>
                            <button class="mr-3 text-red-600 hover:text-red-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none"
                                v-show="authUser.is_admin == '1' && authUser.id != user.id"  
                                @click="destroy(user.id)">
                                <font-awesome-icon :icon="['fas', 'trash-alt']"  />
                            </button>
                        </div>
                    </div>
                                        
                </div>
                                 
             </div>
        </div>
    </div>
    <!-- End of Small Devices -->
          

    <!-- Bigger Devices -->
    <div v-else class="py-8">

    <!-- THEAD -->
    <div class="uppercase rounded-t-full text-sm flex justify-between items-baseline shadow-inner p-4 text-gray-800 w-full">
        <div class="w-4/12 pt-4 ml-4 font-semibold">Užívateľ</div>
        <div class="w-4/12 ml-6 pt-4 font-semibold">Pracuje v</div>
        <div class="w-2/12 ml-7 pt-4 font-semibold ">Status</div>
        <div class="w-2/12 mr-2 pt-4 text-center font-semibold">Registrovaný</div>
    </div>
    <!-- / THEAD -->
        <ul v-for="user in users" :key="user.id" class="text-sm even:bg-warmGray-300 rounded-full odd:bg-warmGray-400" >
            <!-- TBODY -->
                <li class="flex justify-between items-center rounded-l-full m-2 text-gray-800 w-full">
                    <div class="w-4/12 ml-6 py-1">
                        <p class="font-semibold">{{ user.name }}
                            <font-awesome-icon @click="showDetails(user.id)" 
                                                v-if="details[user.id] == true" 
                                                :icon="['fas', 'chevron-circle-up']" class="border cursor-pointer ounded align-bottom bg-warmGray-100 opacity-25 text-xl py-1 ml-1"/>
                            <font-awesome-icon @click="showDetails(user.id)" 
                                                v-else 
                                                :icon="['fas', 'ellipsis-h']" class="border cursor-pointer rounded align-bottom bg-warmGray-100 opacity-25 text-xl py-1 ml-1"/>
                        </p>
                        <div v-if="details[user.id] == true" class="mt-1 mb-0.5">
                            <a :href="'mailto:' + user.email"
                                class="hover:font-bold">
                                {{ user.email }}
                            </a>
                        </div>
                        <div>
                            <a :href="'tel:' + user.phone"
                                v-if="details[user.id] == true"
                                class="hover:font-bold">
                                {{ user.phone }}
                            </a>
                        </div>
                    </div>
                    <div class="w-4/12">
                        <a href="" @click.prevent="showBranch(user.branch.id, $event)" class="hover:font-bold">
                            {{ user.branch.name }}
                        </a>
                    </div>
                    <div class="w-2/12" :class="user.is_admin == 'Admin' ? 'text-gold-500 font-bold' : 'text-gold=300'">{{ user.role }}</div>
                    <div class="w-2/12 flex">
                        {{ user.created_at }}
                        <div v-if="details[user.id] == true" class="flex justify-end items-center mr-3">
                        <!-- Edit Button -->
                            <NuxtLink :to="{ name: 'auth-edit', params: { id: user.id }}" v-show="authUser.is_admin == '1'">
                                <font-awesome-icon :icon="['fas', 'pencil-alt']"  class="mr-3 text-gray-500 hover:text-gray-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none rounded"/>
                            </NuxtLink>
                            <button class="mr-6 text-red-600 hover:text-red-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none"
                                v-show="authUser.is_admin == '1' && authUser.id != user.id"  
                                @click="destroy(user.id)">
                                <font-awesome-icon :icon="['fas', 'trash-alt']"  />
                            </button>
                        </div>
                    </div>
                </li>
            <!-- / TBODY -->
        </ul>
    </div>
    
    <div v-if="users" v-show="paginationTotal > 10">
        <Pagination store="users" collection="users" :filter="filter" />
    </div>
</div>
</template>

<script>    
import {mapState, mapActions, mapMutations} from 'vuex'
import FilterNav from './FilterNav'
import Pagination from './Pagination'

export default {
    name: "Users",

    props: ['smallDevice'],

    data: () => ({
        destroyId: '',
        confirm: false,
        filter: {
            sortByUnread: Boolean,
            filterByCategory: []
        },
        details: {}
    }),

    mounted(){
        this.getAllUsers();
    },

    computed: {
        ...mapState({
            users: state => state.users.users.data,
            authUser: state => state.auth.user,
            paginationTotal: state => state.users.users.meta.total,
            modal: state => state.modal.modal,
            allUsers: state => state.users.allUsers.data,
        }),
        userForDestroy() {
            return this.users.filter(user => user.id == this.destroyId);
        },
    },

    async fetch() {
        await this.$store.dispatch('users/getList', { pageNumber: 0, filterByCategory: this.filter.filterByCategory})
    },

    methods: {
        ...mapMutations({
             setModal : 'modal/setModal',
             setTab: 'dashboardTab/SET_TAB',
        }),
        ...mapActions({
            deleteUser: 'users/deleteUser',
            getList: 'users/getList',
            setSpinner: 'spinner/setSpinner',
            getAllUsers: 'users/getAllUsers'
        }),

        showDetails(id) {
            const idExists = Object.keys(this.details).find(el => el == id);
            console.log(idExists)
            if(idExists == undefined) {
                this.$set(this.details, id,  true);
            } else {
                this.$set(this.details, id, false);
                delete this.details[id];
            }
            
        },
        destroy(id){
            this.confirm = true;
            this.setModal(true);
            this.destroyId = id;
        },
        confirmDeletion() {
            this.setModal(false);
            this.deleteUser(this.destroyId);
            this.destroyId = '';
        },
        cancelDeletion() {
            this.confim = false;
            this.setModal(false);
            this.destroyId = 0;
        },
        async showBranch(id, event) {
            await this.$store.dispatch('branches/getSelected', id);
            this.setTab('branches')
        },
    },

    watch: {

        filter: {
            deep: true,

            handler(newVal, oldVal) {
                if(newVal) {
                    // this.getList(0, true)
                    this.$store.dispatch('users/getList', { pageNumber: 0, filterByCategory: this.filter.filterByCategory})
                }
            }
        },

        // Turn off Spinner when data changed.
        users: {
            deep: true,
            handler(newVal, oldVal) {
                if(newVal.length > 0) {
                    this.setSpinner(false);
                }
            }
        },
        
    },

    components: {
        FilterNav,
        Pagination,
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