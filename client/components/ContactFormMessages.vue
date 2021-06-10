<template>
<div class="z-10 relative">
        <h2 class="text-gold-500 py-2 uppercase">Správy od zákazníkov</h2>
        
        <FilterNav store="contactForm" 
                @sortByUnread = "filter.sortByUnread = $event" 
                @filterByBranch = "filter.filterByBranch = $event" />
    <!-- <div class="absolute w-full flex justify-center">
        <Spinner />
    </div> -->
    <!-- Small Device -->
    <div v-if="smallDevice">

        <div v-for="message in messages" :key="message.id">

            <!-- Message iter. -->
            <div class="text-gray-200 rounded-sm border p-2 mb-1 border-black transition delay-250 duration-500 ease-in"
                 :class="{'bg-gray-200 text-gray-700 font-bold': message.read == 0 }">
                <div class="flex justify-between">
                    <div class="flex flex-col">
                        <p class=" text-gray-100">Meno a kontakt: </p>
                            <p class="ml-2 text-gray-700">
                                {{ message.name }}
                                    <br>
                                <a :href="'mailto:' + message.email" class="hover:text-gray-100">{{ message.email }}</a>
                                    <br >
                                <a :href="'tel:' + message.phone" class="hover:text-gray-100"> {{ message.phone }}</a>
                            </p>
                    </div>
                    
                    <div class="flex flex-col">
                        <p class="text-gray-100">Pre pobočku: </p> 
                            <a href="" @click.prevent="showBranch(message.branch.id, $event)" class="ml-2 text-gray-700 hover:text-gray-900">
                                {{ message.branch.name }}                                
                            </a>
                    </div>
                </div>

                    <p class="text-gray-100">Správa: </p>
                        <div>
                            <div @click="showMsg(message.message, message.id, $event)" 
                                  class="ml-2 text-gray-700 cursor-pointer"
                                  :class="{'underline' : fullMsgText === false}">
                                <!-- Show/Hide part of text with VannilaJS  -->
                                    {{ message.message.slice(0, 40) }} . . . 
                            </div>
                        </div>
                    <p class=" text-gray-100">Prijatá: </p>
                        <p class="ml-2 text-gray-700"> 
                            {{ message.created_at }}
                        </p>
             </div>
        </div>
    </div>

    <!-- Bigger Devices -->
    <div v-else>

        <table class="my-5 mx-auto bg-gray-400 py-8 table-fixed">
            <thead class=" text-gray-100">
                <tr>
                    <th class="w-3/12 py-2">Meno a kontakt</th>
                    <th class="w-2/12">Pre pobočku</th>
                    <th class="w-6/12">Správa</th>
                    <th class="w-1/12">Prijatá</th>
                </tr>
            </thead>
            <tbody v-for="message in messages" :key="message.id">
                <tr class="text-gray-200 rounded-xl border-2 border-black transition delay-250 duration-500 ease-in"
                    :class="{'bg-gray-200 text-gray-700 font-bold': message.read == 0 }">
                    <td class="pl-2 w-3/12">
                        {{ message.name }}
                            <br>
                        <a :href="'mailto:' + message.email" class="hover:text-gray-800">{{ message.email }}</a>
                            <br >
                        <a :href="'tel:' + message.phone" class="hover:text-gray-800"> {{ message.phone }}</a>
                    </td>
                    <td class="text-center w-3/12 text-gray-600 hover:text-gray-900 hover:font-bold">
                        <a href="" @click.prevent="showBranch(message.branch.id, $event)">{{ message.branch.name }}</a>
                    </td>
                    <td title="Otvoriť správu" class="text-center w-6/12">
                        <div @click="showMsg(message.message, message.id, $event)" 
                              class="hover:text-gold-500 relative transition duration-500 ease-in-out cursor-pointer"
                              :class="{'underline': fullMsgText === false }">
                            <!-- Show/Hide part of text with VannilaJS  -->
                                {{ message.message.slice(0, 40) }} . . . 
                        </div>
                    </td>
                    <td class="w-1/12 pr-1 text-gray-800">{{ message.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div v-if="messages" v-show="paginationTotal > 10">
        <Pagination store="contactForm" collection="messages" :filter="filter" />
    </div>
</div>
</template>

<script>    
import {mapState, mapMutations, mapActions} from 'vuex'
import Pagination from './Pagination'
import FilterNav from './FilterNav'
import Modal from './Modal'

export default {
    name: "ContactFormMessages",

    props: {
        smallDevice: {},
        store: {}
    },

    data: () => ({
        fullMsgText: false,
        filter: {
            sortByUnread: Boolean,
            filterByBranch: []
        }
    }),

    computed: {
        ...mapState({
            messages: state => state.contactForm.messages.data,
            modal: state => state.modal.modal,
            paginationTotal: state => state.contactForm.messages.meta.total
        }),
    },

    async fetch(){
        await this.$store.dispatch('contactForm/getList', { pageNumber: 0, sortByUnread: this.filter.sortByUnread, filterByBranch: this.filter.filterByBranch});
        await this.getNoticationsNum();
        await this.$store.dispatch('branches/getNotPaginatedList');

    },

    methods: {
        // ...mapMutations({
        //     //  setModal: 'modal/setModal',
        //     //  setSpinner: 'spinner/SET_SPINNER'
        // }),

        ...mapMutations({ setTab : 'dashboardTab/SET_TAB' }),
        ...mapActions({
             getNoticationsNum: 'contactForm/getNotificationsNum',
        }),
    
        async showBranch(id, event) {
            await this.$store.dispatch('branches/getSelected', id);
            this.setTab('branches')
        },


        async showMsg(text, id, event) {
                
            if(event.target.innerText.length > 46) {
                //SHORTEN TEXT
                event.target.innerText = text.slice(0, 40) + ' . . .';
                // Unmark Unread Message(FrontEnd)
                event.target.parentElement.parentElement.classList.remove('bg-gray-200', 'text-gray-700', 'font-bold');
                this.fullMsgText = false;
                
            } else {
                // Mark message
                event.target.parentElement.parentElement.classList.add('bg-gray-200', 'text-gray-700', 'font-bold' );

                // SHOW FULL TEXT
                event.target.innerText = `${text}  [ . . . čítaj menej ]`;
                this.fullMsgText = true;
                // Unmark Unread Message(BackEnd)
                try {
                    await this.$axios.$get('sanctum/csrf-cookie');
                    await this.$axios.post('api/messages', { 
                        id: id,   
                        messageOpened: true 
                    });
                    await this.$store.dispatch('contactForm/getNotificationsNum')
                } catch (e) {
                    console.log(e.response)
                }
            }
        },
    },

    watch: {

        filter: {
            deep: true,

            handler(newVal, oldVal) {
                if(newVal) {
                    // this.getList(0, true)
                    this.$store.dispatch('contactForm/getList', { pageNumber: 0, sortByUnread: this.filter.sortByUnread, filterByBranch: this.filter.filterByBranch})
                }
            }
        }
    },

    components: {
        // Spinner,
        Modal,
        Pagination,
        FilterNav
    }
}
</script>
