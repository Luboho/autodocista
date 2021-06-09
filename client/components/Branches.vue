<template>
<div>
    <!-- <div v-if="branches.length > 1">  -->
    <h2 class="text-gold-500 py-2 uppercase">Naše pobočky</h2>
    <!-- </div> -->
    <!-- <div v-else @click="refreshData()" class="flex items-center cursor-pointer">
        <font-awesome-icon :icon="['fas', 'redo']" class="text-gold-500 hover:text-gold-600" />
        <h2 class="text-gold-500 py-2 ml-2">načítať všetky pobočky</h2>
    </div> -->
    <!-- Confirm Item deletion -->
        <div v-if="confirm && modal" class="flex justify-center items-center absolute w-full">  <!-- If modal is true SHOW -->
            <div class="fixed text-white rounded-lg z-30 p-8 bg-gray-800">
                <p>Ste si istý, že chcete zmazať záznam? 
                </p>
                <p v-show="branchForDestroy.name" class="text-gold-500 font-bold">
                    {{ branchForDestroy.name }}
                </p>

                <div class="flex items-center mt-6 justify-end">               <!-- Set modal to opposite to HIDE modal-->
                    <button @click="cancelDeletion" class="text-white pr-4">Zrušiť</button>
                    <button @click="confirmDeletion" class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white">Zmazať</button>
                </div>
            </div>
        </div> 
     <!--End of Confirm Item deletion -->
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
                                <a :href="'mailto:' + branch.email" class="hover:text-gray-100">{{ branch.email }}</a>
                            <br>
                                <a :href="'tel:' + branch.phone" class="hover:text-gray-100">{{ branch.phone }}</a> 
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
                <div class="flex justify-between">
                <div>
                    <p class=" text-gray-100">Vytvorená: </p>
                        <p class="ml-2 text-gray-500 font-semibold"> 
                            {{ branch.created_at }}
                        </p>
                </div>
                <div>
                    <p>
                        &nbsp;
                    </p>
                    <button 
                        v-show="authUser.is_admin == '1'"  
                        @click="destroy(branch.id)"
                        class="text-2xl font-black mr-2 focus:outline-none align-items-middle text-red-800 hover:text-red-600">
                        x 
                    </button>
                </div>
                </div>
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
                    <th class="text-center w-4/12">Adresa</th>
                    <th class="text-center w-1/12">Vytvorená</th>
                    <th class="text-center w-1/12"></th>
                </tr>
            </thead>
            <tbody v-for="branch in branches" :key="branch.id">
                <tr class="text-gray-200 rounded-xl border-2 border-black transition delay-700 duration-500 ease-in">
                    <td class="w-3/12 pl-2 first:text-gray-800">
                        <span class="text-gray-600 font-bold">
                            {{ branch.name }}
                        </span>    
                            <br>
                        <a :href="'mailto:' + branch.email" class="hover:text-gray-800">{{ branch.email }}</a>
                            <br>
                        <a :href="'tel:' + branch.phone" class="hover:text-gray-800">{{ branch.phone }}</a>
                    </td>
                    <td class="text-center w-3/12 text-gray-800 font-semibold">{{ branch.city }}</td>
                    <td class="text-center w-5/12">{{ branch.address }}</td>
                    <td class="text-center w-1/12 pr-1 text-gray-800">{{ branch.created_at }}</td>
                    <td>
                        <button 
                            v-show="authUser.is_admin == '1'"  
                            @click="destroy(branch.id)"
                            class="text-2xl font-black mr-2 focus:outline-none align-items-middle text-red-800 hover:text-red-600">
                            x 
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <Modal />
    
    <div v-if="branches" v-show="paginationTotal > 10">
        <Pagination store="branches" collection="branches" :filter="filter" />
    </div>
</div>
</template>

<script>    
import {mapState, mapActions, mapMutations} from 'vuex'
// import Spinner from './Spinner'
import Modal from './Modal'
import Pagination from './Pagination'

export default {
    name: "Branches",

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
            branches: state => state.branches.branches.data,
            // branch: state => state.branches.branch.data,
            authUser: state => state.auth.user,
            modal: state => state.modal.modal,
            paginationTotal: state => state.branches.branches.meta.total
            // spin: state => state.spinner.spin
        }),
        branchForDestroy:  {
            get: function() {
                return this.branches.filter(branch => branch.id == this.destroyId);
            },
        }
    },

    async fetch() {
        await this.$store.dispatch('branches/getList', { pageNumber: 0});
    },

    methods: {
        ...mapActions({
            refreshData: 'branches/getList',
            deleteBranch: 'branches/deleteBranch'
        }),
        ...mapMutations({
             setModal : 'modal/setModal',
            //  setSpinner: 'spinner/SET_SPINNER'
        }),

        refreshData() {
            this.$store.dispatch('branches/getList', { pageNumber: 0});
        },

        destroy(id) {
            this.confirm = true;
            this.setModal(true);
            this.destroyId = id;
        },
        confirmDeletion(){
            this.setModal(false);
            this.deleteBranch(this.destroyId);
            this.destroyId = '';
        },
        cancelDeletion() {
            this.confirm = false;
            this.setModal(false);
            this.destroyId = 0;
        }
        
    },

    watch: {

            filter: {
                deep: true,

                handler(newVal, oldVal) {
                    if(newVal) {
                        this.$store.dispatch('branches/getList', { pageNumber: 0})
                    }
                }
            }
    },

    components: {
        // Spinner,
        Modal,
        Pagination
    }
}
</script>
