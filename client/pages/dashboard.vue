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
                    <div v-if="tab == 'messages'">
                        <ContactFormMessages />
                    </div>
                    <div v-else-if="tab == 'users'">
                        <Users />
                    </div>
                    <div v-else-if="tab == 'branches'">
                        <Branches />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'
import ContactFormMessages from '../components/ContactFormMessages'
import Users from '../components/Users'
import Branches from '../components/Branches'
 
export default {
    name: "dashboard",

    async mounted() {
        await this.$store.dispatch('contactForm/getMessages')
    },

    computed: {

        ...mapGetters({
            tab: 'dashboardTab/tab'
        })
    },

    methods: {
        ...mapMutations({ setTab : 'dashboardTab/setTab' }),
    },

    components: {
        ContactFormMessages,
        Branches,
        Users
    }
}
</script>

<style>

</style>