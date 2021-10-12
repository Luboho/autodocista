<template>

<div>
  <nav class="bg-gray-900 py-10 relative z-40">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-5">
        <!-- Bigger Devices Home Icon -->
            <nuxt-link :to="'/'" class="hidden sm:flex justify-center mt-10 border-b-4 border-gold-100 rounded-full border-opacity-75 py-8 items-center">
              <img src="@/assets/default-images/logo200x121.png" alt="Auto Dočista">
            </nuxt-link>
            <!-- Mobile Home Icon -->
            <nuxt-link :to="'/'" class="not-sr-only sm:sr-only ">
                <img src="@/assets/default-images/logo.png" alt="Auto Dočista">
            </nuxt-link>

            <!-- Mobile BURGER MENU button-->
            <div class="absolute ml-28 inset-y-0 flex items-center justify-end sm:hidden">
              <button id="mobile-dropdown" @click="mobileDropdown = !mobileDropdown" 
                      type="button" 
                      class="animate inline-flex items-center justify-center p-2 rounded-md text-gray-400 
                          hover:text-white hover:bg-gray-700 transform active:scale-75 focus:outline-none focus:ring-2 focus:ring-inset 
                            focus:ring-white transition duration-500 ease-in-out" aria-controls="mobile-menu" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <!-- Icon when menu is closed. -->
                <!--
                  Heroicon name: outline/menu

                  Menu open: "hidden", Menu closed: "block"
                -->
                <svg class="text-gold-500 block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <!-- Icon when menu is open. -->
                <!--
                  Heroicon name: outline/x

                  Menu open: "block", Menu closed: "hidden"
                -->
              </button>
            </div>

        <!-- Bigger Device MENU items -->
        <div class="flex items-center sm:items-stretch">
              
            <div class="hidden sm:block sm:ml-6">
              <nuxt-link to="/about" 
                         class="text-gold-500 leading-10 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 font-medium
                                transition duration-500 ease-in-out"
                         :class="{ 'border-b-4 border-gold-500': currentPath == '/about' }"

              >
                O nás
              </nuxt-link>
              <nuxt-link to="/prices" 
                         class="text-gold-500 leading-10 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 font-medium
                                 transition duration-500 ease-in-out"
                         :class="{ 'border-b-4 border-gold-500': currentPath == '/prices' }"
           
              >
                Cenník
              </nuxt-link>
              <nuxt-link to="/contact-us" 
                         class="text-gold-500 leading-10 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 font-medium
                               transition duration-500 ease-in-out"
                         :class="{ 'border-b-4 border-gold-500': currentPath == '/contact-us' }"
              >
                Napíšte nám
              </nuxt-link>
              <nuxt-link to="/locations" 
                         class="text-gold-500 leading-10 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 font-medium whitespace-no-wrap
                                transition duration-500 ease-in-out"
                         :class="{ 'border-b-4 border-gold-500': currentPath == '/locations' }"
              >
                Nájdete nás
              </nuxt-link>
            </div>
        </div>
        <!-- End of Bigger Device Menu Items -->

          <div class="absolute inset-y-0 flex right-0 justify-end items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            
            <!-- Notifications Bell/New message counter -->
            <button v-if="this.$auth.loggedIn" v-show="notificationNum > 0" 
                    class="p-1 text-gray-100 hover:text-white transition duration-500 ease-in-out transform active:scale-75 focus:outline-none focus:ring-2 
                           focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <div @click="setTab('messages')">
                <nuxt-link :to="{name: 'dashboard', params: {unreadMsg: true }}"  class="flex text-red-600 align-top font-bold text-xs" role="menuitem">

                  <div class="border-l-2 border-r-2 mr-3 absolute border-red-600 animate-ping rounded-full w-6 h-6"></div>

                  <div>&nbsp;</div>
                  <font-awesome-icon :icon="['fas', 'envelope']"  class="transition text-lg text-white mt-1 rounded"/>
                  <span class="px-1 py-1 border border-white rounded-full">{{ notificationNum }}</span>
                </nuxt-link>
              </div>
            </button>
            <!-- End of Notifications -->

<!-- Right Side -->
            <!-- Profile dropdown -->
            <div class="ml-3 relative">
                    <button id="user-dropdown" @click="userDropdown = !userDropdown" 
                            class="flex text-sm rounded-full transition duration-500 ease-in-out transform active:scale-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" 
                            aria-haspopup="true">
                      <span class="sr-only">Otvoriť užívateľské menu</span>
                      <div v-if="!this.$auth.loggedIn">
                        <font-awesome-icon :icon="['fas', 'user-circle']"  class="text-4xl text-gold-500 align-middle" /> 
                      </div>
                      <div v-else class="text-gold-500">      
                        {{ $store.state.auth.user.name }}
                        <font-awesome-icon :icon="['fas', 'caret-down']"  class="text-gold-500 align-middle" /> 
                      </div>
                    </button>
                
                  <div v-if="this.$auth.loggedIn">
                    <transition name="dropdown">
                      <div v-if="userDropdown" @click="closeDropdown" 
                           class="origin-top-right absolute rounded right-0 mt-2 w-36 border border-gold-500 bg-gray-600 text-gold-500 py-1 z-100 transition duration-500 ease-in-out" 
                           role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                          <nuxt-link to="/dashboard" class="block px-4 py-2 text-sm hover:bg-gray-400 transition duration-500 ease-in-out" 
                                     role="menuitem">
                              Správca
                          </nuxt-link>
                          <nuxt-link to="/in-construction" class="block px-4 py-2 text-sm hover:bg-gray-400 transition duration-500 ease-in-out" 
                                     role="menuitem">
                              Môj profil
                          </nuxt-link>
                          <nuxt-link to="/in-construction" class="block px-4 py-2 text-sm hover:bg-gray-400 transition duration-500 ease-in-out" 
                                     role="menuitem">
                              Nastavenia
                          </nuxt-link>
                          <div @click="setTab('branches')">
                            <nuxt-link  to="/dashboard"  class="block px-4 py-2 text-sm hover:bg-gray-400 transition duration-500 ease-in-out" role="menuitem">
                                Prevádzky  
                            </nuxt-link>
                          </div>
                          <nuxt-link v-if="this.$auth.user.is_admin == 1" to="/branch/create" role="menuitem" class="block pl-6 pr-4 py-2 text-xs hover:bg-gray-400 transition duration-500 ease-in-out">
                            Pridať prevádzku
                          </nuxt-link>
                          <div @click="setTab('branches')">
                            <nuxt-link v-if="this.$auth.user.is_admin == 1" to="/dashboard" role="menuitem" class="block pl-6 pr-4 py-2 text-xs hover:bg-gray-400 transition duration-500 ease-in-out">
                                Upraviť údaje prevádzky
                            </nuxt-link>
                          </div>
                          <a href="#" @click.prevent="logout" class="block px-4 py-2 text-sm border-t-0.5 border-gray-400  text-red-500 transition duration-500 ease-in-out hover:bg-gray-400" role="menuitem">
                            Odhlásiť sa
                          </a>
                      </div>
                    </transition>
                  </div>

                  <div v-else>
                    <transition name="dropdown">
                      <div v-if="userDropdown" 
                           class="origin-top-right absolute rounded right-0 mt-2 w-48 border border-gold-500 bg-gray-600 text-gold-500 py-1 z-100" 
                           role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                        <nuxt-link to="/auth/login" 
                                   class="text-gold-500 hover:text-gold-400 transition duration-500 ease-in-out hover:font-bold flex justify-items-center justify-center py-1 text-sm font-medium"
                        >
                          <a href="" @click="closeDropdown" class="whitespace-no-wrap px-1">Prihlásiť sa</a>
                        </nuxt-link>                    
                      </div>
                    </transition>
                  </div>
            </div>

        </div>
      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <transition name="dropdown">
      <div v-if="mobileDropdown" class="sm:hidden" id="mobile-menu">
          <div @click="closeDropdown" class="flex flex-col flex-grow px-2 pt-4 pb-3 space-y-1">
              <nuxt-link to="/about" 
                         class="text-gold-500 hover:bg-gold-500 ml-26 transition duration-500 ease-in-out hover:text-yellow-900 hover:font-bold px-3 py-4 text-sm font-medium"
                         :class="{ 'border-l-4 border-gold-500': currentPath == '/about' }"
              > 
                O nás
              </nuxt-link>
              <nuxt-link to="/prices" 
                         class="text-gold-500 hover:bg-gold-500 ml-26 transition duration-500 ease-in-out hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium"
                         :class="{ 'border-l-4 border-gold-500': currentPath == '/prices' }"
              >
                Cenník
              </nuxt-link>
              <nuxt-link to="/contact-us" 
                         class="text-gold-500 hover:bg-gold-500 ml-26 transition duration-500 ease-in-out hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium"
                         :class="{ 'border-l-4 border-gold-500': currentPath == '/contact-us' }"
              >
                Napíšte nám
              </nuxt-link>
              <nuxt-link to="/locations" 
                         class="text-gold-500 hover:bg-gold-500 ml-26 transition duration-500 ease-in-out hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium whitespace-no-wrap"
                         :class="{ 'border-l-4 border-gold-500': currentPath == '/locations' }"
              >
                Nájdete nás
              </nuxt-link>
          </div>
      </div>
    </transition>

  </nav>
  <div v-if="modal" @click="closeDropdown" class="fixed flex items-center justify-center bg-opacity-50 bg-black z-20 top-0 left-0 right-0 bottom-0"></div>
  
  <!-- <div class="absolute">
    <font-awesome-icon @click="share = !share" :icon="['fas', 'share-alt']" class="cursor-pointer hover:text-gold-500 tranform transition duration-500 ease-in-out transform active:scale-75 text-5xl border-1 hover:border-gold-300 rounded-xl p-2 w-16 h-auto text-gray-200 m-4 fixed z-40 bottom-0 "  />
    <div v-if="share" class="ml-16 slide">
        <SocialSharing />
    </div>
  </div> -->

  
</div>
</template>

<script>
import {mapState, mapMutations, mapActions} from 'vuex'
import SocialSharing from './../../components/SocialSharing.vue'

export default {
    data: () => ({
        userDropdown: false,
        mobileDropdown: false,
        share: false
    }),

   async fetch() {
      await this.getNoticationsNum();
    },

    computed: {
      modal() {
          if(this.userDropdown || this.mobileDropdown) {
            return true;
          } else {
            return false;
          }
        },

      currentPath() {
        return this.$route.path;
      },

      // Notifications
       ...mapState({
          // messages: state => state.contactForm.messages.data,
          notificationNum: state => state.contactForm.notificationNum
        }),
    },

    methods: {
        ...mapMutations({ setTab : 'dashboardTab/SET_TAB' }),
        ...mapActions({ getNoticationsNum: 'contactForm/getNotificationsNum'}),

        closeDropdown: function(e) {
            this.userDropdown = false;
            this.mobileDropdown = false;
        },
        
        async logout() {
          await this.$auth.logout()
        },
    },
    components: {
      SocialSharing
    }
}
</script>

<style scoped>
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
.slide {
  animation-duration: 0.8s;
  animation-name: slidein;
}
@keyframes slidein {
  from {
    margin-left: 5000px;
  }

  to {
    margin-left: 65px;
  }
}
</style>