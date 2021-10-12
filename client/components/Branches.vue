<template>
<div>
    <div v-if="branches">
        <div v-if="branches.length > 0">

            <div v-if="branches">
                <div v-if="branches.length > 1">
                    <div class="flex justify-between mx-2">
                        <h2 class="text-gold-500 py-2 uppercase">Naše pobočky</h2>
                        <div v-show="authUser.is_admin == '1'" class="flex justify-end items-center">
                            <span class="text-gray-300">Pridať</span>
                            <NuxtLink :to="{name: 'branch-create'}"
                                class="text-gold-400 text-2xl ml-2 mr-1 active:text-gold-700 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none"
                            >
                                <font-awesome-icon :icon="['fas', 'plus']" />
                            </NuxtLink>
                        </div>
                    </div> 
                </div>
                <div v-else @click="refreshData()" class="flex items-center cursor-pointer">
                    <button class="text-gold-500 active:text-gold-700 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none">
                        <font-awesome-icon :icon="['fas', 'redo']" class="" />
                        <h2 class="text-gold-500 hover:text-gold-600 py-2 ml-2">...všetky pobočky</h2>
                    </button>
                </div>
            </div>
            <!-- Confirm Item deletion -->
                <div v-if="confirm && modal" class="flex justify-center items-center absolute w-full">  <!-- If modal is true SHOW -->
                    <div class="fixed text-white rounded-lg z-50 p-8 bg-gray-800">
                        <p>Ste si istý, že chcete zmazať záznam? 
                        </p>
                        <p v-show="branchForDestroy" class="text-gold-500 font-bold">
                            {{ branchForDestroy[0].name }}
                        </p>

                        <div class="flex items-center mt-6 justify-end">               <!-- Set modal to opposite to HIDE modal-->
                            <button @click="cancelDeletion" class="text-white pr-4 transition duration-500 ease-in-out transform active:scale-75">Zrušiť</button>
                            <button @click="confirmDeletion" class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white transition duration-500 ease-in-out transform active:scale-75">Zmazať</button>
                        </div>
                    </div>
                </div> 
            <Spinner />
            <!--End of Confirm Item deletion -->


            <!-- Small Device -->
            <div v-if="smallDevice">
                <div v-for="branch in branches" :key="branch.id" class="even:bg-warmGray-300 rounded-md m-3 mx-auto w-full odd:bg-warmGray-400">
                    <div class="text-gray-200 border-0.5 p-2 mb-1 border-black transition delay-700 duration-500 ease-in">
                        <div class="flex flex-col ">

                        <div class="flex flex-col">
                            <p class=" text-gray-800 font-bold">Kontakt: </p>
                            <p class="ml-2 text-gray-700">
                                {{ branch.name }}
                                    <br>
                                <a :href="'mailto:' + branch.email" class="hover:font-bold">{{ branch.email }}</a>
                                    <br >
                                <a :href="'tel:' + branch.phone" class="hover:font-bold">{{ branch.phone }}</a>
                            </p>
                        </div>
                            
                            <div class="flex flex-col sm:flex-row ml-2">
                                <div class="flex flex-col">
                                    <p class="text-gray-800 font-bold">Mesto:  </p> 
                                        <p class="ml-2 text-gray-700">
                                            {{ branch.city }}                                
                                        </p>
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-gray-800 font-bold">IČO:  </p> 
                                    <p class="ml-2 text-gray-800">
                                        {{ branch.ico }}                                
                                    </p>
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-800 font-bold">Adresa:  </p>
                            <div class="text-gray-800 ml-2">
                                {{ branch.address }}
                            </div>
                        <div class="flex justify-between">
                            <div>
                                <p class=" text-gray-800 font-bold">Vytvorená: </p>
                                <p class="ml-2 text-gray-800"> 
                                    {{ branch.created_at }}
                                </p>
                            </div>
                            <div>
                                <p>
                                    &nbsp;
                                </p>
                                <!-- Edit Button -->
                                <NuxtLink :to="{ name: 'branch-edit', params: { id: branch.id }}" v-show="authUser.is_admin == '1'">
                                    <font-awesome-icon :icon="['fas', 'pencil-alt']"  class="mr-3 text-gray-600 hover:text-gray-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none rounded"/>
                                </NuxtLink>
                                <button class="mr-3 text-red-600 hover:text-red-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none"
                                    v-show="authUser.is_admin == '1'"  
                                    @click="destroy(branch.id)">
                                    <font-awesome-icon :icon="['fas', 'trash-alt']"  />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bigger Devices -->
            <div v-else class="py-8">

            <!-- THEAD -->
    <div class="uppercase rounded-t-full text-sm flex justify-between items-baseline shadow-inner p-4 text-gray-800 w-full">
        <div class="w-5/12 pt-4 ml-8 font-semibold">Kontakt</div>
        <div class="w-5/12 pt-4 ml-5 font-semibold">Adresa</div>
        <div class="w-2/12 pt-4 mr-6 text-center font-semibold">Vytvorená</div>
    </div>
    <!-- / THEAD -->
        <ul v-for="branch in branches" :key="branch.id" class=" even:bg-warmGray-300 rounded-full odd:bg-warmGray-400" >
            <!-- TBODY -->
                <li class="flex justify-between items-center rounded-l-full text-sm m-2 px-4 py-1 text-gray-800 w-full">
                    <div class="w-5/12 ml-6 py-1">
                        <p class="font-semibold">{{ branch.name }}
                            <font-awesome-icon @click="showDetails(branch.id)" 
                                                v-if="details[branch.id] == true" 
                                                :icon="['fas', 'chevron-circle-up']" class="border cursor-pointer ounded align-bottom bg-coolGray-100 opacity-25 text-xl py-1 ml-1"/>
                            <font-awesome-icon @click="showDetails(branch.id)" 
                                                v-else 
                                                :icon="['fas', 'ellipsis-h']" class="border cursor-pointer rounded align-bottom bg-coolGray-100 opacity-25 text-xl py-1 ml-1"/>
                        </p>
                        <div v-if="details[branch.id] == true" class="mt-1 mb-0.5">
                            <a :href="'mailto:' + branch.email"
                                class="hover:font-bold">
                                {{ branch.email }}
                            </a>
                        </div>
                        <div>
                            <a :href="'tel:' + branch.phone"
                                v-if="details[branch.id] == true"
                                class="hover:font-bold">
                                {{ branch.phone }}
                            </a>
                        </div>
                        <div>
                            <p v-if="details[branch.id] == true">
                                <span class="font-bold text-xs">IČO:</span>
                                {{ branch.ico }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="w-5/12 mx-5">
                        <p class="font-semibold">{{ branch.city }}</p>
                        {{ branch.address }}
                    </div>
                    <div class="w-2/12 flex">
                        {{ branch.created_at }}
                        <div v-if="details[branch.id] == true" class="flex justify-end items-center mr-3">
                            <!-- Edit Button -->
                            <NuxtLink :to="{ name: 'branch-edit', params: { id: branch.id }}" v-show="authUser.is_admin == '1'">
                                <font-awesome-icon :icon="['fas', 'pencil-alt']"  class="mr-3 text-gray-500 hover:text-gray-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none rounded"/>
                            </NuxtLink>
                            <button class="mr-3 text-red-600 hover:text-red-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none"
                                v-show="authUser.is_admin == '1'"  
                                @click="destroy(branch.id)">
                                <font-awesome-icon :icon="['fas', 'trash-alt']"  />
                            </button>
                        </div>
                    </div>
                </li>
            <!-- / TBODY -->
        </ul>

            </div>
            <div v-if="branches" v-show="paginationTotal > 10">
                <Pagination store="branches" collection="branches" :filter="filter" />
            </div>
        </div>
        </div>

    <div v-else>
        Žiadne záznamy.
    </div>
</div>
</template>

<script>    
import {mapState, mapActions, mapMutations} from 'vuex'
import Spinner from './Spinner'
import Pagination from './Pagination'

export default {
    name: "Branches",
    transtion: 'file',

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

    computed: {
        ...mapState({
            branches: state => state.branches.branches.data,
            // branch: state => state.branches.branch.data,
            authUser: state => state.auth.user,
            modal: state => state.modal.modal,
            paginationTotal: state => state.branches.branches.meta.total
            // spin: state => state.spinner.spin
        }),
        branchForDestroy() {
            return this.branches.filter(branch => branch.id == this.destroyId);
        },
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
             setSpinner: 'spinner/SET_SPINNER'
        }),

        refreshData() {
            this.$store.dispatch('branches/getList', { pageNumber: 0});
        },

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
        Spinner,
        Pagination
    }
}
</script>
<style scoped>

</style>
