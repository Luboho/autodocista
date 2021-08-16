<template>
<div> 
    <h2 class="text-gold-500 py-2 uppercase">Registrovaní užívatelia</h2>
    <FilterNav store="users" 
               @sortByUnread = "filter.sortByUnread = $event" 
               @filterByBranch = "filter.filterByBranch = $event"
               :dataList="this.users" />

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
                    <button @click="cancelDeletion" class="text-white pr-4">Zrušiť</button>
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
                                <a :href="'mailto:' + user.email" class="hover:text-gray-100">{{ user.email }}</a>
                                    <br >
                                <a :href="'tel:' + user.phone" class="hover:text-gray-100">{{ user.phone }}</a>
                            </p>
                    </div>
                    
                    <div class="flex flex-col">
                        <p class="text-gray-100">Pracuje:  </p> 
                            <p @click.prevent="showBranch(user.branch.id, $event)" class="ml-2 text-gray-600 hover:text-gray-900 cursor-pointer hover:font-bold">
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
                        <a :href="'mailto:' + user.email" class="hover:text-gray-800">{{ user.email }}</a>
                            <br >
                        <a :href="'tel:' + user.phone" class="hover:text-gray-800">{{ user.phone }}</a>
                    </td>
                    <td @click.prevent="showBranch(user.branch.id, $event)" 
                        class="text-center w-4/12 text-gray-600 hover:text-gray-900 cursor-pointer hover:font-bold">
                            {{ user.branch.name }}
                    </td>
                    <td v-show="authUser.is_admin == '1'"
                        class="text-center w-2/12"
                        :class="user.is_admin == 'Admin' ? 'text-gold-500 font-bold' : 'text-gold-300'">
                       {{ user.is_admin }}
                    </td>
                    <td class="text-center w-3/12 text-gray-800">{{ user.created_at }}</td>
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

    <div v-if="users" v-show="paginationTotal > 10">
        <Pagination store="users" collection="users" :filter="filter" />
    </div>
</div>
</template>

<script>    
import {mapState, mapActions, mapMutations} from 'vuex'
import FilterNav from './FilterNav'
import Modal from './Modal'
import Pagination from './Pagination'

export default {
    name: "Users",

    props: ['smallDevice'],

    data: () => ({
        destroyId: '',
        confirm: false,
        filter: {
            sortByUnread: Boolean,
            filterByBranch: []
        }
    }),

    computed: {
        ...mapState({
            users: state => state.users.users.data,
            authUser: state => state.auth.user,
            paginationTotal: state => state.users.users.meta.total,
            modal: state => state.modal.modal,
        }),
        userForDestroy() {
            return this.users.filter(user => user.id == this.destroyId);
        }
    },

    async fetch() {
        await this.$store.dispatch('users/getList', { pageNumber: 0, filterByBranch: this.filter.filterByBranch})
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
        }),

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
                    this.$store.dispatch('users/getList', { pageNumber: 0, filterByBranch: this.filter.filterByBranch})
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
        }
    },

    components: {
        FilterNav,
        Modal,
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