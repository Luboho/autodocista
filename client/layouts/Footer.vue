<template>
  <div class="w-full h-auto text-gray-300 text-sm bg-gray-900">
      <div class="grid grid-cols-1 justify-items-center place-content-start sm:grid-cols-3 gap-4 sm:gap-2 xs:justify-items-center">

            <div class="flex flex-col p-10 bg-opacity-50">
                <p class="mt-3">&nbsp;</p>
                <nuxt-link to="/" 
                         class="text-gold-500 hover:text-yellow-200 hover:font-bold pl-4 py-2"
                         :class="{ 'border-l-4 -ml-1 border-gold-500': currentPath == '/' }"
                >
                    <h1>Domov</h1>
                </nuxt-link>
                <nuxt-link to="/about" 
                         class="text-gold-500 hover:text-yellow-200 hover:font-bold pl-4 py-2 text-sm font-medium"
                         :class="{ 'border-l-4 -ml-1 border-gold-500': currentPath == '/about' }"

                >
                    <h1>O nás</h1>
                </nuxt-link>
                <nuxt-link to="/prices" 
                            class="text-gold-500 hover:text-yellow-200 hover:font-bold pl-4 py-2 text-sm font-medium"
                            :class="{ 'border-l-4 -ml-1 border-gold-500': currentPath == '/prices' }"
            
                >
                    <h1>Cenník</h1>
                </nuxt-link>
                <nuxt-link to="/contact-us" 
                            class="text-gold-500 hover:text-yellow-200 hover:font-bold pl-4 py-2 text-sm font-medium"
                            :class="{ 'border-l-4 -ml-1 border-gold-500': currentPath == '/contact-us' }"
            
                >
                    <h1>Napíšte nám</h1>
                </nuxt-link>
                <nuxt-link to="/locations" 
                            class="text-gold-500 hover:text-yellow-200 hover:font-bold pl-4 py-2 text-sm font-medium"
                            :class="{ 'border-l-4 -ml-1 border-gold-500': currentPath == '/locations' }"
            
                >
                    <h1>Nájdete nás</h1>
                </nuxt-link>
            </div>

<!-- Company Branchies -->
            <div @mouseleave="hover = false" class="px-20 py-10 mt-2  border border-gold-500 rounded-md relative bg-opacity-50">
                    <h1 class="font-bold pb-1 text-center">Prevádzky</h1>
                    <transition name="dropdown">
                        <div class="absolute z-100 inset-y-0 text-gold-500 bg-gray-600" v-if="hover">
                            <div class="flex flex-col content-center">
                                <HoverContacts class="self-center" :name="branch[0].name" :phone="branch[0].phone" :email="branch[0].email" :ico="branch[0].ico" />
                                <img src="@/assets/default-images/logo200x121.png" class="self-center w-1/2"  alt="Auto Dočista">
                            </div>
                        </div>
                    </transition>
                    <div v-for="branch in branches" :key="branch.id" class="py-2 whitespace-no-wrap">
                        <h2 @mouseover="hoverCity(branch.id)">{{ branch.name }}  
                            <font-awesome-icon :icon="['fas', 'info']" class="text-xs ml-1 align-baseline text-gold-500 inline-block" />
                        </h2>
                    </div>
            </div>

            <div class="p-10  bg-opacity-50">
                <h1 class="font-bold py-3">Otváracie hodiny:</h1>
                <div class="flex">
                    <div class="">
                        <p>Pondelok:</p> 
                        <p>Utorok: </p>
                        <p>Streda: </p>
                        <p>Štvrtok: </p>
                        <p>Piatok: </p>
                        <p>Sobota: </p>
                        <p>Nedeľa: </p>
                    </div>
                    <div>
                        <p class="whitespace-no-wrap text-right  ml-2"> 7:30 - 18:00</p>
                        <p class="whitespace-no-wrap text-right  ml-2"> 7:30 - 18:00</p>
                        <p class="whitespace-no-wrap text-right  ml-2"> 7:30 - 18:00</p>
                        <p class="whitespace-no-wrap text-right  ml-2"> 7:30 - 18:00</p>
                        <p class="whitespace-no-wrap text-right  ml-2"> 7:30 - 18:00</p>
                        <p class="whitespace-no-wrap text-right  ml-2"> 7:30 - 12:00</p>
                        <p class="whitespace-no-wrap text-right  ml-2">Zatvorené </p>
                    </div>
                </div>
            </div>

        </div>
    <p class="p-3 py-8 top text-sm text-gray-300 text-center"> © 2020-2021. ZipZap digital. Všetky práva vyhradené. </p>

  </div>
</template>

<script>
    import {mapState} from 'vuex'
    import HoverContacts from "../components/HoverContacts"
    import SocialSharing from "./../components/SocialSharing.vue"
    export default {

        name: "Footer",
        
        data: () => ({
            hover: false,
            id: "",
        }),

        async mounted() {
            await this.$store.dispatch('branches/getNotPaginatedList');
        },

        computed: {
            currentPath() {
                return this.$route.path;
            },

            ...mapState({
                branches: state => state.branches.notPaginatedBranches.data
            }),

            branch() {
                return this.branches.filter(branch => branch.id == this.id);
            }
        },
        methods: {
            hoverCity(id) {
                this.id = id;
                this.hover = true;
            },

        },
        components: {
            HoverContacts,
            SocialSharing
        }
    }
</script>

<style>
.dropdown-enter,
.dropdown-leave-to {
  transform: scaleY(0.1);
  opacity: 0;
}

.dropdown-enter-to,
.dropdown-leave {
  opacity: 1;
  transform: scaleY(1);
}

.dropdown-enter-active,
.dropdown-leave-active,
.dropdown-leave-to {
  transition: all 0.35s ease-in-out;
  transform-origin: top center;
}
</style>