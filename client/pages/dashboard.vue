<template>
    <div>
        <div class="p-2 mt-28 mb-2 relative mx-auto max-w-1024">
            <div class="-mt-9.5 absolute flex flex-row text-gray-100 ">
                <button @click="setTab('messages')" 
                        class="focus:outline-none bg-gray-300 mr-1 rounded-t-md  px-3 py-2"
                        :class="{ 'bg-gray-400 ' : tab == 'messages' }"
                >
                    Správy
                </button>
                <button @click="setTab('users')" 
                        class="focus:outline-none bg-gray-300 mr-1 rounded-t-md px-3 py-2"
                        :class="{ 'bg-gray-400 ' : tab == 'users' }"
                >
                    Užívatelia
                </button>
                <button @click="setTab('branches')" 
                        class="focus:outline-none bg-gray-300 mr-1 rounded-t-md px-3 py-2"
                        :class="{ 'bg-gray-400 ' : tab == 'branches' }"
                >
                    Pobočky
                </button>
            </div>

            <div class="relative mb-1 mr-1 border-b-4 border-r-4 border-gray-400">
                <div class="mb-1 mr-1 border-b-1 border-r-1 border-gray-200">
                    <div class="mb-1 mr-1 border-b-1 border-r-1 border-gray-200">
                        <div class="relative mb-1 mr-1 bg-gray-400 mx-auto p-3">
                            <transition name="fade">
                                <div v-show="tab == 'messages'">
                                    <ContactFormMessages :smallDevice="smallDevice" />
                                </div>
                            </transition>
                            <transition name="fade">
                                <div v-show="tab == 'users'">
                                    <Users :smallDevice="smallDevice" />
                                </div>
                            </transition>
                            <transition name="fade">
                                <div v-show="tab == 'branches'">
                                    <Branches :smallDevice="smallDevice" />
                                </div>
                            </transition>
                        </div>

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
    head: {
        title: "Ovládací panel"
    },
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

<style scoped>

</style>