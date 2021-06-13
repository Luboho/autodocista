<template>
    <div>
            
            <div class="p-4 mt-20 relative">
                <div class="-mt-10 absolute flex flex-row text-gray-100 ">
                    <button @click="setTab('messages')" 
                            class="focus:outline-none bg-gray-300 mr-1 rounded-t-md  p-2"
                            :class="{ 'bg-gray-400 ' : tab == 'messages' }"
                    >
                        Správy
                    </button>
                    <button @click="setTab('users')" 
                            class="focus:outline-none bg-gray-300 mr-1 rounded-t-md p-2"
                            :class="{ 'bg-gray-400 ' : tab == 'users' }"
                    >
                        Užívatelia
                    </button>
                    <button @click="setTab('branches')" 
                            class="focus:outline-none bg-gray-300 mr-1 rounded-t-md p-2"
                            :class="{ 'bg-gray-400 ' : tab == 'branches' }"
                    >
                        Pobočky
                    </button>
                </div>

                <div class="rounded-b rounded-r bg-gray-400">
                    <div class="relative mb-5 mx-auto px-4 py-8 rounded-b">
                        <div v-show="tab == 'messages'">
                            <ContactFormMessages :smallDevice="smallDevice" />
                        </div>
                        <div v-show="tab == 'users'">
                            <Users :smallDevice="smallDevice" />
                        </div>
                        <div v-show="tab == 'branches'">
                            <Branches :smallDevice="smallDevice" />
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from 'vuex'
import ContactFormMessages from '../components/ContactFormMessages'
import Users from '../components/Users'
import Branches from '../components/Branches'
import Pagination from '../components/Pagination'
import Spinner from '../components/Spinner.vue'
import Modal from '../components/Modal.vue'
 
export default {
    name: "dashboard",
    middleware: 'authenticated',

    data: () => ({
        smallDevice: true
    }),

    async mounted() {

        this.fitTableByDeviceWidth();

        window.onresize = () => {
            if (window.innerWidth < 768){
                this.smallDevice = true;
            } else {
                this.smallDevice = false;
            }
        };
    },

    computed: {
        ...mapGetters({
            tab: 'dashboardTab/tab',
        })
    },

    methods: {
        ...mapMutations({ setTab : 'dashboardTab/SET_TAB' }),

        fitTableByDeviceWidth() {
            if (window.innerWidth < 768){
                this.smallDevice = true;
            } else {
                this.smallDevice = false;
            }
        },
    },

    components: {
        ContactFormMessages,
        Branches,
        Users,
        Pagination,
        Spinner,
        Modal
    }
}

</script>

<style>

</style>