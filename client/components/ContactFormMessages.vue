<template>
<div>
    <!-- Small Device -->
    <div v-if="smallDevice">
        <div v-for="message in messages" :key="message.id"  
             class="border border-gray-400 transition delay-700 duration-500 ease-in text-gray-100 p-2"
             :class="{'bg-gray-900': message.read == 0 }">
             <div class="flex justify-between">
                 <div class="flex justify-start">
                    <p class=" text-gold-400">Meno: </p>
                        <p class="font-light italic text-gray-200 ml-2"> {{ message.name }} </p>
                 </div>
                
                <div class="flex justify-end">
                    <p class=" text-gold-400">Kontakt: </p> 
                        <p class="font-light italic text-gray-200 ml-2">
                            {{ message.email }}
                                <br >
                            {{ message.phone }}
                        </p>
                </div>
             </div>
                <p class=" text-gold-400">Správa: </p>
                    <div>
                        <div @click="showMsg(message.message, message.id, $event)" class="cursor-pointer text-gold-100 hover:text-gold-300">
                            <!-- Show/Hide part of text with VannilaJS  -->
                                {{ message.message.slice(0, 40) }} → 
                        </div>
                    </div>
                <p class=" text-gold-400">Prijatá: </p>
                    <p class="font-light italic text-gray-200"> 
                        {{ message.created_at }}
                    </p>
        </div>
    </div>

    <!-- Bigger Devices -->
    <div v-else>
        <table class="my-5 mx-auto px-4 py-8 bg-gray-500 rounded table-fixed">
            <thead class="border border-gray-400 text-gray-100 p-3 ">
                <tr class="">
                    <th class="w-2/12">Meno</th>
                    <th class="w-3/12">Kontakt</th>
                    <th class="w-6/12">Správa</th>
                    <th class="w-1/12">Prijatá</th>
                </tr>
            </thead>
            <tbody v-for="message in messages" :key="message.id"
                   class="m-1 text-gray-200 "
                   >
                <tr class="border border-gray-400 transition delay-700 duration-500 ease-in"
                    :class="{'bg-gray-900': message.read == 0 }">
                    <td class="">{{ message.name }}</td>
                    <td class="">
                        {{ message.email }}
                        <br >
                        {{ message.phone }}
                    </td>
                    <td class="px-2 ">
                        <div @click="showMsg(message.message, message.id, $event)" class="cursor-pointer text-gold-200 hover:text-gold-300">
                            <!-- Show/Hide part of text with VannilaJS  -->
                            {{ message.message.slice(0, 40) }} → 
                        </div>
                    </td>
                    <td class="">{{ message.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>    
import {mapState} from 'vuex'

export default {
    name: "DashboardTable",

    data: () => ({
        smallDevice: true,
        clickedMsg: false,
    }),


    computed: {
        ...mapState({
            messages: state => state.contactForm.messages,
        }),
    },

    async mounted() {
        await this.$store.dispatch('contactForm/getMessages'),

        this.fitMessagesWindow();

        window.onresize = () => {
            if (window.innerWidth < 768){
                this.smallDevice = true;
            } else {
                this.smallDevice = false;
            }
        };
    },

    methods: {
        async showMsg(text, id, event) {
            if(event.target.innerText.length > 42) {
                //SHORTEN TEXT
                event.target.innerText = text.slice(0, 40) + ' →';  
            } else {
                // SHOW FULL TEXT
                event.target.innerText = `${text}  ←`;
                // Unmark Unread Message
                event.target.parentElement.parentElement.classList.remove('bg-gray-900');
               
                try {
                    await this.$axios.$get('sanctum/csrf-cookie');
                    await this.$axios.post('api/get-messages', { 
                        id: id,   
                        messageOpened: true 
                    })
                        
                } catch (e) {
                    console.log(e.response)
                }
            }
        },

        fitMessagesWindow() {
            if (window.innerWidth < 768){
                this.smallDevice = true;
            } else {
                this.smallDevice = false;
            }
        }
    }
}
</script>