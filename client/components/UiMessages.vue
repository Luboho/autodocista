<template>
    <div>
        <transition name="show">
            <div v-if="uiMessage">
                <div class="flex justify-center items-center absolute w-full"> 
                    <div class="fixed text-white rounded-lg z-30 p-8"
                        :class="bgColor">
                        {{ msg }}
                    </div>
                </div> 
            </div>
        </transition>
        
    </div>
</template>

<script>

import { mapState } from 'vuex'

export default {
    name: "UiMessages",

    data: () => ({
        bgColor: "",
        showMsg: false
    }),

    computed: {
        ...mapState({
            uiMessage: state => state.uiMessages.uiMessage.data
        }),

        msg() {
            if(this.uiMessage) {
                
                if(this.uiMessage.errors) {
                    return this.uiMessage.errors.root
                } else if (this.uiMessage.success) {
                    return this.uiMessage.success
                } else if (this.uiMessage.warning) {
                    return this.uiMessage.warning
                }
            }
        }
    },

    methods: {
        removeUiMessage() {
            if(true) {
                setTimeout(() => {
                    this.$store.dispatch('uiMessages/getUiMessage', {})
                }, 5000);
            }
        }
    },

    watch: {

        uiMessage: {
            deep: true,

            handler(newVal, oldVal) {
                if(newVal) {
                    if(this.uiMessage.errors) {
                        this.bgColor = "bg-red-600";
                    } else if (this.uiMessage.success) {
                        this.bgColor = "bg-green-600"
                    } else if (this.uiMessage.warning) {
                        this.bgColor = "bg-yellow-600"
                    }

                    // Remove Message
                    this.removeUiMessage();
                }
            }
        }
    },
}
</script>

<style>
.show-enter-active,
.show-leave-enter {
    transform: translateX(0);
    transition: all .3s linear;
}
.show-enter,
.show-leave-to {
    transform: translateX(100%);
}
</style>