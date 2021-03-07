<template>

<div>
  <nav class="bg-gray-800 relative z-30">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <div class="hidden sm:flex justify-center items-center">
          <div>
            <nuxt-link :to="'/'">
              <img src="@/assets/default-images/logo.png" alt="Auto Dočista">
            </nuxt-link>
          </div>
        </div>
        <div class="absolute inset-y-0 flex items-center justify-end sm:hidden">
          <!-- Mobile menu button-->
          <button id="mobile-dropdown" @click="mobileDropdown = !mobileDropdown " type="button" class="animate inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
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

        <nuxt-link :to="'/'" class="not-sr-only sm:sr-only mx-auto">
          <img src="@/assets/default-images/logo.png" alt="Auto Dočista">
        </nuxt-link>
        
        <div class="flex items-center sm:items-stretch">
              
            <div class="hidden sm:block sm:ml-6">
              <nuxt-link to="/about" 
                         class="text-gold-500 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium"
                         :class="{ 'border-b-4 border-gold-500': currentPath == '/about' }"

              >
                O nás
              </nuxt-link>
              <nuxt-link to="/prices" 
                         class="text-gold-500 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium"
                         :class="{ 'border-b-4 border-gold-500': currentPath == '/prices' }"
           
              >
                Cenník
              </nuxt-link>
              <nuxt-link to="/reserve" 
                         class="text-gold-500 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium"
                         :class="{ 'border-b-4 border-gold-500': currentPath == '/about' }"
           
              >
                Objednať sa
              </nuxt-link>
              <nuxt-link to="/prices" 
                         class="text-gold-500 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium"
                         :class="{ 'border-b-4 border-gold-500': currentPath == '/about' }"
           
              >
                Nájdete nás
              </nuxt-link>
            </div>
        </div>

          <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <button class="p-1 rounded-full text-gray-100 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">View notifications</span>
              <!-- Heroicon name: outline/bell -->
              <div>
                  <font-awesome-icon :icon="['fas', 'bell']"  class="align-middle text-xl color-white"/> 
               </div>
            </button>

            <!-- Profile dropdown -->
            <div class="ml-3 relative">
                <div>
                    <button id="user-dropdown" @click="userDropdown = !userDropdown" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-haspopup="true">
                    <span class="sr-only">Open user menu</span>
                      <font-awesome-icon :icon="['fas', 'user-circle']"  class=" text-3xl text-gold-500 align-middle" /> 
                    </button>
                </div>
                
                <transition
                  enter-active-class="transform transition duration-500 ease-custom"
                  enter-class="-translate-y-1/2 scale-y-0 opacity-0"
                  enter-to-class="translate-y-0 scale-y-100 opacity-100"
                  leave-active-class="transform transition duration-300 ease-custom"
                  leave-class="translate-y-0 scale-y-100 opacity-100"
                  leave-to-class="-translate-y-1/2 scale-y-0 opacity-0"
                >
                    <div v-if="userDropdown" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-100" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</a>
                    </div>
                </transition>

            </div>

        </div>
      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <transition
            enter-active-class="transform transition duration-500 ease-custom"
            enter-class="-translate-y-1/2 scale-y-0 opacity-0"
            enter-to-class="translate-y-0 scale-y-100 opacity-100"
            leave-active-class="transform transition duration-300 ease-custom"
            leave-class="translate-y-0 scale-y-100 opacity-100"
            leave-to-class="-translate-y-1/2 scale-y-0 opacity-0"
    >
      <div v-if="mobileDropdown" class="sm:hidden" id="mobile-menu">
          <div class="flex flex-col flex-grow px-2 pt-2 pb-3 space-y-1">
              <nuxt-link to="/about" 
                         class="text-gold-500 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium"
                         :class="{ 'border-l-4 border-gold-500': currentPath == '/about' }"
              > 
                O nás
              </nuxt-link>
              <nuxt-link to="/prices" 
                         class="text-gold-500 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium"
                         :class="{ 'border-l-4 border-gold-500': currentPath == '/prices' }"
              >
                Cenník
              </nuxt-link>
              <nuxt-link to="/prices" 
                         class="text-gold-500 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium"
                         :class="{ 'border-l-4 border-gold-500': currentPath == '/about' }"
              >
                Objednať sa
              </nuxt-link>
              <nuxt-link to="/prices" 
                         class="text-gold-500 hover:bg-gold-500 hover:text-yellow-900 hover:font-bold px-3 py-2 text-sm font-medium"
                         :class="{ 'border-l-4 border-gold-500': currentPath == '/about' }"
              >
                Nájdete nás
              </nuxt-link>
          </div>
      </div>
    </transition>

  </nav>
  <div v-if="modal" @click="closeDropdown" class="fixed flex items-center justify-center bg-opacity-25 bg-black z-20 top-0 left-0 right-0 bottom-0"></div>
  
</div>
</template>

<script>
export default {
    data: () => ({
        userDropdown: false,
        mobileDropdown: false,
    }),

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
    },


    methods: {

        closeDropdown: function(e) {
            this.userDropdown = false;
            this.mobileDropdown = false;
        },

        // openDropdown = ! : function(e) {
        //   if(e.currentTarget.id == 'user-dropdown') {
        //     console.log(e.currentTarget.id);

        //     this.userDropdown = true;
        //     this.modal = true;
        //   } else if(e.currentTarget.id == 'mobile-dropdown') {
        //     this.mobileDropdown = true;
        //     this.modal = true;
        //   }
        // }
    }
}
</script>

<style>
    
</style>