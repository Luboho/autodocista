<template>
<div>
    <h2 class="text-gold-500 py-2 uppercase">Správy od zákazníkov</h2>
    
    <div class="absolute w-full flex justify-center">
        <Spinner :loading="loading" />
    </div>
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
                                <a :href="'mailto:' + message.email">{{ message.email }}</a>
                                    <br >
                                <a :href="'tel:' + message.phone"> {{ message.phone }}</a>
                            </p>
                    </div>
                    
                    <div class="flex flex-col">
                        <p class="text-gray-100">Pre pobočku: </p> 
                            <p class="ml-2 text-gray-700">
                                {{ message.branch.name }}                                
                            </p>
                    </div>
                </div>

                    <p class="text-gray-100">Správa: </p>
                        <div>
                            <div @click="showMsg(message.message, message.id, $event)" class="ml-2 text-gray-700 cursor-pointer">
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
                        <a :href="'mailto:' + message.email">{{ message.email }}</a>
                            <br >
                        <a :href="'tel:' + message.phone"> {{ message.phone }}</a>
                    </td>
                    <td class="text-center w-3/12">{{ message.branch.name }}</td>
                    <td class="text-center w-6/12">
                        <div @click="showMsg(message.message, message.id, $event)" class="hover:text-gold-800 cursor-pointer">
                            <!-- Show/Hide part of text with VannilaJS  -->
                            {{ message.message.slice(0, 40) }} . . . 
                        </div>
                    </td>
                    <td class="w-1/12 pr-1">{{ message.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>    
import {mapState} from 'vuex'
import Spinner from './Spinner'

export default {
    name: "DashboardTable",

    data: () => ({
        smallDevice: true,
        clickedMsg: false,
    }),


    computed: {
        ...mapState({
            messages: state => state.contactForm.messages,
            loading: state => state.contactForm.loading
        }),
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
        await this.$store.dispatch('contactForm/getMessages')
    },

    methods: {
        async showMsg(text, id, event) {
            if(event.target.innerText.length > 46) {
                //SHORTEN TEXT
                event.target.innerText = text.slice(0, 40) + ' . . .';
                // Unmark Unread Message
                event.target.parentElement.parentElement.classList.remove('bg-gray-200', 'text-gray-700', 'font-bold');
                
            } else {
                // Mark message
                event.target.parentElement.parentElement.classList.add('bg-gray-200', 'text-gray-700', 'font-bold');

                // SHOW FULL TEXT
                event.target.innerText = `${text}  [ . . . čítaj menej ]`;

                try {
                    await this.$axios.$get('sanctum/csrf-cookie');
                    await this.$axios.post('api/messages', { 
                        id: id,   
                        messageOpened: true 
                    });
                    await this.$store.dispatch('contactForm/getMessages')

                        
                } catch (e) {
                    console.log(e.response)
                }
            }
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
        Spinner
    }
}
</script>
