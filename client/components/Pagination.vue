<template>
  <!-- <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
    <div class="flex-1 flex justify-between sm:hidden">
      <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
        Previous
      </a>
      <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
        Next
      </a>
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Zobrazuje sa
          {{ pagination.current_page }}
          z
          {{ pagination.last_page }}
          stránok.
          Celkovo          
          {{ pagination.total }}
          výsledkov
        </p>
      </div>
      <div>
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <span class="sr-only">Predchádzajuca</span>
                <font-awesome-icon :icon="['fas', 'chevron-left']"  /> 
          </a>
          <div v-for="link in links" :key="link.index">
            <a :href="link" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                {{ link.label }}
            </a>    
          </div>
           <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
            1
          </a>
          <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
            2
          </a>
          <a href="#" class="hidden md:inline-flex relative items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
            3
          </a>
          <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
            ...
          </span>
          <a href="#" class="hidden md:inline-flex relative items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
            8
          </a>
          <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
            9
          </a>
          <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
            10
          </a> -->
          <!-- <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <span class="sr-only">Nasledujúca</span>
                <font-awesome-icon :icon="['fas', 'chevron-right']"  /> 
          </a>
        </nav>
      </div>
    </div>
  </div> -->
  <div>
    <div class="text-center">
        <v-pagination
          v-model="currentPage"
          :length="lastPage"
          :total-visible="8"
          :dark="true"
          :color="'#a9a9aa'"
        ></v-pagination>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['store', 'collection'],

    watch: {
      currentPage(newVal, oldVal) {
        this.paginatePage(newVal);
      }
    },

    computed: {

      currentPage: {
        get() {
          return this.$store.state[this.store][this.collection].meta.current_page;
        },
        set( value ){
          this.$store.commit(this.store + '/SET_CURRENT_PAGE', value);
        }
      }, 

      lastPage: {
        get() {
          return this.$store.state[this.store][this.collection].meta.last_page;
        } 
      }, 
    },
  
  methods: {
    paginatePage(pageNumber) {
      this.$store.dispatch(this.store + '/getList', pageNumber);
    }
  }
}
</script>