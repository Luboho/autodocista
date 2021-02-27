<template>

<div>
  <nav class="bg-gray-800 relative z-30">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <div class="hidden sm:flex justify-center items-center">
          <div>
            <img src="@/assets/default-images/logo.png" alt="Domov">
          </div>
          <h1 class="text-xl text-white font-bold">Auto Dočista</h1>
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
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <!-- Icon when menu is open. -->
            <!--
              Heroicon name: outline/x

              Menu open: "block", Menu closed: "hidden"
            -->
          </button>
        </div>
        
        <div class="flex items-cente sm:items-stretch">
              
            <div class="hidden sm:block sm:ml-6">
              <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
              <a href="#" class="text-yellow-300 hover:bg-yellow-300 hover:text-yellow-900 px-3 py-2 rounded-md text-sm font-medium">O nás</a>
              <a href="#" class="text-yellow-300 hover:bg-yellow-300 hover:text-yellow-900 px-3 py-2 rounded-md text-sm font-medium">Cenník</a>
              <a href="#" class="text-yellow-300 hover:bg-yellow-300 hover:text-yellow-900 px-3 py-2 rounded-md text-sm font-medium">Objednať sa</a>
              <a href="#" class="text-yellow-300 hover:bg-yellow-300 hover:text-yellow-900 px-3 py-2 rounded-md text-sm font-medium">Nájdete nás</a>
            </div>
        </div>

          <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <button class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">View notifications</span>
              <!-- Heroicon name: outline/bell -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
            </button>

            <!-- Profile dropdown -->
            <div class="ml-3 relative">
                <div>
                    <button id="user-dropdown" @click="userDropdown = !userDropdown" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-haspopup="true">
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full" src="@/assets/default-images/user.png" alt="">
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
          <div class="px-2 pt-2 pb-3 space-y-1">
              <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
              <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Calendar</a>
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
        }
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