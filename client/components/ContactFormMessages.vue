<template>
<div>
    <h2 class="text-gold-500 mt-4 mb-6 px-auto uppercase">Správy od zákazníkov</h2>
    <Spinner />
    <div v-if="messages">
        <div v-if="messages.length > 0" class=" relative px-auto">
            <div v-if="$auth.user.is_admin == '1'">
                <FilterNav store="contactForm" 
                            @sortByUnread = "filter.unread = $event" 
                            @filterByCategory = "filter.filterByCategory = $event"
                            :dataList="messages"
                            :allMessages="allMessages" />
            </div>

            <!-- Small Device -->
            <div v-if="smallDevice">

                <div v-for="message in messages" :key="message.id" class="even:bg-warmGray-300 rounded-md m-3 mx-auto w-full odd:bg-warmGray-400">

                    <!-- Message iter. -->
                    <div class="text-gray-200 text-sm border-0.5 p-2 mb-1 border-black transition delay-250 duration-500 ease-in"
                        :class="{'bg-gold-600' : message.read == '0' }">
                        <div class="flex justify-between">
                            <div class="flex flex-col">
                            <p class=" text-gray-800 font-bold">Meno a kontakt: </p>
                                <p class="ml-2 text-gray-700">
                                    {{ message.name }}
                                        <br>
                                    <a :href="'mailto:' + message.email" class="hover:font-bold">{{ message.email }}</a>
                                        <br >
                                    <a :href="'tel:' + message.phone" class="hover:font-bold">{{ message.phone }}</a>
                                </p>
                        </div>
                            
                            <div class="flex flex-col">
                                <p class="text-gray-800 font-bold">Pre pobočku: </p> 
                                    <a href="" @click.prevent="showBranch(message.branch.id, $event)" class="ml-2 text-gray-600 hover:text-gray-900 cursor-pointer hover:font-bold">
                                        {{ message.branch.name }}                                
                                    </a>
                            </div>
                        </div>

                            <p class="text-gray-800 font-bold">Správa: </p>
                                <div>
                                    <div @click="showDetails(message.id, $event)" 
                                        class="ml-2 text-gray-700 cursor-pointer hover:text-gold-800"
                                        :class="{'no-underline': details[message.id] === true, 'font-black' : message.read == '0', }">
                                        <!-- Show/Hide part of text with VannilaJS  -->
                                            {{ message.message.slice(0, 21) }}
                                    </div>
                                </div>
                            <div class="flex justify-between">
                            <div>
                                <p class="text-gray-800 font-bold">Prijatá: </p>
                                <p class="ml-2 text-gray-700"> 
                                    {{ message.created_at }}
                                </p>
                            </div>
                            <div>
                                <p>
                                    &nbsp;
                                </p>
                                
                                <NuxtLink to="in-construction" v-show="$auth.user.is_admin == '1'">
                                    <font-awesome-icon :icon="['fas', 'pencil-alt']"  class="mr-3 text-gray-500 hover:text-gray-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none rounded"/>
                                </NuxtLink>
                                <button class="mr-3 text-red-600 hover:text-red-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none"
                                    v-show="$auth.user.is_admin == '1'" >
                                    <NuxtLink to="in-construction">
                                        <font-awesome-icon :icon="['fas', 'trash-alt']"  />
                                    </NuxtLink>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bigger Devices -->
            <div v-else class="my-8">

                <!-- THEAD -->
        <div class="uppercase rounded-t-full text-sm flex justify-evenly items-baseline shadow-inner p-4 text-gray-800 w-full">
            <div class="w-3/12 ml-2 pt-4 font-semibold">Meno a kontakt</div>
            <div class="w-2/12 ml-8 pt-4 font-semibold">Príjimateľ</div>
            <div class="w-5/12 ml-5 pt-4 font-semibold">Správa</div>
            <div class="w-2/12 text-center mr-7 pt-4 font-semibold">Prijatá</div>
        </div>
        <!-- / THEAD -->
            <ul v-for="message in messages" :key="message.id" class="even:bg-warmGray-300 rounded-full odd:bg-warmGray-400 ">
                <!-- TBODY -->
                    <li class="flex justify-evenly text-sm items-center rounded-full my-2 text-gray-800 w-full transition duration-500 ease-in-out"
                        :class="{'bg-gold-600' : message.read == '0' }">
                        <div class="w-3/12 ml-6 py-1">
                            <p class="font-semibold">{{ message.name }}
                            <div v-if="details[message.id] == true" class="mt-1 mb-0.5">
                                <a :href="'mailto:' + message.email"
                                    class="hover:font-bold">
                                    {{ message.email }}
                                </a>
                            </div>
                            <div>
                                <a :href="'tel:' + message.phone"
                                    v-if="details[message.id] == true"
                                    class="hover:font-bold">
                                    {{ message.phone }}
                                </a>
                            </div>
                        </div>
                        <div class="w-2/12">
                            <a href="" @click.prevent="showBranch(message.branch.id, $event)" class="hover:font-bold">
                                {{ message.branch.name }}
                            </a>
                        </div>
                        <div @click="showDetails(message.id, $event)" 
                            class="w-5/12 hover:text-gold-900 relative transition underline duration-500 ease-in-out cursor-pointer"
                            :class="{'no-underline': details[message.id] === true, 'font-black' : message.read == '0', }">
                            <!-- Show/Hide part of text with VannilaJS  -->
                                {{ message.message.slice(0, 21) }}
                    </div>
                        <div class="w-1/12 flex">
                            {{ message.created_at }}
                            <div v-if="details[message.id] == true" class="flex items-center mr-3">
                            <!-- Edit Button -->
                                <NuxtLink to="in-construction" v-show="$auth.user.is_admin == '1'">
                                    <font-awesome-icon :icon="['fas', 'pencil-alt']"  class="mr-3 text-gray-500 hover:text-gray-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none rounded"/>
                                </NuxtLink>
                                <button class="mr-6 text-red-600 hover:text-red-500 transition duration-500 ease-in-out transform active:scale-75 focus:outline-none"
                                    v-show="$auth.user.is_admin == '1'"  
                                    ><NuxtLink to="in-construction" v-show="$auth.user.is_admin == '1'">
                                        <font-awesome-icon :icon="['fas', 'trash-alt']"  />
                                    </NuxtLink>
                                </button>
                            </div>
                        </div>
                    </li>
                <!-- / TBODY -->
            </ul>

            </div>
            <div v-if="messages" v-show="paginationTotal > 10">
                <Pagination store="contactForm" collection="messages" :filter="filter" />
            </div>
        </div>
        <div v-else class="flex justify-start ml-8" >
            <p>Zatiaľ žiadne správy</p>
            <svg class="ml-20" id="Capa_1" enable-background="new 0 0 512 512" height="100" viewBox="0 0 512 512" width="100" xmlns="http://www.w3.org/2000/svg"><g><path d="m512 256c0 66.476-25.338 127.035-66.883 172.544-46.814 51.282-114.208 79.002-189.117 79.002-141.385 0-250.776-110.161-250.776-251.546 0-74.903 26.945-142.293 78.22-189.107 45.511-41.551 106.074-66.893 172.556-66.893 141.385 0 256 114.615 256 256z" fill="#ffe077"/><g fill="#ffaa5a"><path d="m328.242 390.94c-1.879 0-3.774-.641-5.331-1.956-13.774-11.661-38.621-23.774-66.452-32.403-27.839-8.621-55.177-12.657-73.137-10.847-4.581.536-8.589-2.843-9.056-7.375-.46-4.54 2.847-8.593 7.379-9.052 20.387-2.089 49.411 2.121 79.702 11.5 30.298 9.387 56.621 22.355 72.242 35.573 3.476 2.948 3.911 8.157.968 11.637-1.638 1.931-3.968 2.923-6.315 2.923z"/><path d="m132.121 165.161c-3.855 0-7.306-2.714-8.089-6.637-.895-4.472 2.008-8.823 6.476-9.718l41.29-8.258c4.532-.883 8.831 2.012 9.718 6.476.895 4.472-2.008 8.823-6.476 9.718l-41.29 8.258c-.548.109-1.097.161-1.629.161z"/><path d="m379.879 165.161c-.54 0-1.081-.052-1.629-.161l-41.29-8.258c-4.468-.895-7.371-5.246-6.476-9.718.895-4.476 5.266-7.363 9.718-6.476l41.29 8.258c4.468.895 7.371 5.246 6.476 9.718-.783 3.924-4.234 6.637-8.089 6.637z"/></g><path d="m272.516 495.484c-141.385 0-256-114.615-256-256 0-66.491 25.367-127.078 66.928-172.591-51.265 46.813-83.444 114.213-83.444 189.107 0 141.385 114.615 256 256 256 74.894 0 142.304-32.191 189.117-83.456-45.512 41.561-106.11 66.94-172.601 66.94z" fill="#ffd05b"/><path d="m161.032 198.193c-1.414 0-2.795.14-4.129.411l-12.132 20.235v10.916c0 11.402 4.859 24.869 16.261 24.869s12.779-1.882 16.544-6.916c2.576-3.444 4.102-7.72 4.102-12.352v-16.516c-.001-11.403-9.244-20.647-20.646-20.647z" fill="#845252"/><path d="m156.903 227.097v-28.493c-9.423 1.913-16.516 10.247-16.516 20.235v16.516c0 11.402 9.243 20.645 20.645 20.645 6.736 0 12.776-3.301 16.544-8.293-11.361-.047-20.673-9.238-20.673-20.61z" fill="#7a4646"/><path d="m350.968 198.193c-1.414 0-2.795.14-4.129.411l-12.132 20.235v10.916c0 11.402 4.859 24.869 16.261 24.869s12.779-1.882 16.544-6.916c2.576-3.444 4.102-7.72 4.102-12.352v-16.516c-.001-11.404-9.244-20.647-20.646-20.647z" fill="#845252"/><path d="m346.839 227.097v-28.493c-9.423 1.913-16.516 10.247-16.516 20.235v16.516c0 11.402 9.243 20.645 20.645 20.645 6.736 0 12.776-3.301 16.544-8.293-11.362-.047-20.673-9.238-20.673-20.61z" fill="#7a4646"/></g></svg>
        </div>
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
            unread: false,
            filterByCategory: []
        },
        details: {},
    }),

    computed: {
        ...mapState({
            messages: state => state.contactForm.messages.data,
            messagesState: state => state.contactForm.messages,
            allMessages: state => state.contactForm.allMessages.data,
            modal: state => state.modal.modal,
            paginationTotal: state => state.contactForm.messages.meta.total,
        }),
        unreadMsgs() {
           return this.messages.filter(msg => msg.read == "0")
        } 
    },

    async fetch(){
        await this.$store.dispatch('contactForm/getList', { pageNumber: 0, sortByUnread: this.filter.unread, filterByCategory: this.filter.filterByCategory});
        await this.getNoticationsNum();
        await this.$store.dispatch('branches/getNotPaginatedList');
        await this.$store.dispatch('contactForm/getAllMessages');
    },

    methods: {
        ...mapMutations({ setTab : 'dashboardTab/SET_TAB',
                          setMessages: 'contactForm/SET_MESSAGES',
                          updateMessages: 'contactForm/UPDATE_MESSAGES' }),
        ...mapActions({
             getNoticationsNum: 'contactForm/getNotificationsNum',
             setSpinner: 'spinner/setSpinner',
        }),

        async showBranch(id, event) {
            await this.$store.dispatch('branches/getSelected', id);
            this.setTab('branches')
        },

        async showDetails(id, event) {
            const openedMsg = this.messages.filter(msg => msg.id == id);

            let idExists = Object.keys(this.details).find(el => el == id);
            if(idExists == undefined) {
                this.$set(this.details, id,  true);
            } else {
                this.$set(this.details, id, false);
                delete this.details[id];
                // Remove Unread background
                let currentMsgIndex = this.messages.findIndex(function(msg) {
                    return msg.id === id
                });
                let clonedMsg = JSON.parse(JSON.stringify(openedMsg[0]));
                this.updateMessages({id: currentMsgIndex, value: Object.assign(clonedMsg, {read: "1"})});
                    
            }

            let idSet = Object.keys(this.details).find(el => el == id);

            if(idSet == id) {
                event.target.innerText = openedMsg[0].message;
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
                event.target.parentElement.parentElement.classList.remove('bg-gold-500', 'py-4');
            } else {
                event.target.innerText = openedMsg[0].message.slice(0, 21);
            }
        },

        clickedBell(){
            this.filter.unread = true;
            if(this.$route.params.unreadMsg){
                this.$store.dispatch('contactForm/getList', { pageNumber: 0, sortByUnread: this.filter.unread, filterByCategory: this.filter.filterByCategory})
            }
        },
        async showMsg(text, id, event) {

            if(event.target.innerText.length > 27) {
                //SHORTEN TEXT
                event.target.innerText = text.slice(0, 21) + ' . . .';
                // Unmark Unread Message(FrontEnd)
                event.target.parentElement.parentElement.classList.remove('bg-gold-500', 'py-4');
                this.fullMsgText = false;
                
            } else {
                // Mark message
                event.target.parentElement.parentElement.classList.add('bg-gold-500', 'py-4' );

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
                    this.$store.dispatch('contactForm/getList', { pageNumber: 0, sortByUnread: this.filter.unread, filterByCategory: this.filter.filterByCategory})
                }
            }
        },

        // Turn off Spinner when data changed.
        messages: {
            deep: true,
            handler(newVal, oldVal) {
                if(newVal.length > 0) {
                    this.setSpinner(false);
                }
            }
        },

        "$route.params" : {
            handler: function(val) {
                if(val.unreadMsg == true) {
                    this.clickedBell();
                }
            },
            deep: true,
            immediate: true
        }
    },

    components: {
        Modal,
        Pagination,
        FilterNav
    }
}
</script>
