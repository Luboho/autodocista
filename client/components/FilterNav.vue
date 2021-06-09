<template>
  <div>
      <div v-if="clickedFilter"
        class="absolute w-full left-0 right-0 flex justify-center">


        <div class="relative z-40 w-80 rounded-md bg-gray-300 px-5">
          <!-- Buttons -->
          <div class="sticky flex center justify-center py-4 z-50">
            <button @click="cancelFilter" class="text-gray-400 mr-3 bg-gold-200 hover:bg-gold-300 focus:outline-none shadow-lg hover:shadow-xs rounded pr-4 px-4 py-2 text-sm">
              Zrušiť
              <font-awesome-icon :icon="['fas', 'window-close']" class="ml-2 text-red-500 hover:text-red-600" />
            </button>
              <button @click="clickedFilter = false"  v-if="true" class="px-4 py-2 ml-3 bg-gold-500 hover:bg-gold-400 shadow-lg hover:shadow-xs focus:outline-none rounded text-sm font-bold text-gray-700">
                  Zobraziť
                  &nbsp;
                  ( {{ filtratedMessages.data.length > 0 ? filtratedMessages.data.length : null }} )
              </button>
             <button v-else @click="clickedFilter = false"  disabled="disabled" class="border disabled:border-gray-900 px-4 py-2 ml-3 rounded text-sm text-gray-700">
                Zobraziť
             </button>
          </div>
          
            <div class="py-4 ml-2">
              <label class="custom-checkbox-container text-gray-900 font-semibold cursor-pointer bold uppercase">
                <input @click="sortByUnread" type="checkbox" name="" id="">
                  <span class="mt-0.5">Neprečítané</span>
                  <span class="checkmark"></span>
              </label>
            </div>
            <!-- If More than 8 branches show -->
            <div class="flex items-center border-t border-gray-400 pt-4">
              <div class="">
                <font-awesome-icon :icon="['fas', 'arrows-alt-v']" class="ml-2 text-gold-500 text-xl hover:text-gold-600" />
              </div>
              <p class="text-xs ml-2  text-gray-800">Vybrať podľa pobočky</p>
            </div>

            <div class="border-l border-t rounded-tl-md border-gray-400 font-semibold  p-1 overflow-y-scroll bg-gray-300 max-h-250px">
              <form v-for="branch in notPaginatedBranches" :key="branch.id" class="px-1">
                  <label class="custom-checkbox-container w-80 pb-4 text-gray-900 cursor-pointer">
                    <input @click="filterList(branch.id)" type="checkbox" name="branch" :value="branch.id">
                      <span class="mt-0.5">{{ branch.name }}</span>
                      <span class="checkmark"></span>
                  </label>
              </form>
            </div>

        </div>
      <!-- Make Absolute window with Branch filter && UNread msgs with modal-->
      </div>
      
      <div class="flex">
        <!-- Filter Button -->
        <div class="mb-4 mx-2 float-right">
          <div v-if="filter.filterByBranch.length == 0">
            <button @click="clickedFilter = !clickedFilter" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 hover:text-gray-50 shadow-lg hover:shadow-xs focus:outline-none rounded text-sm text-gray-500">
              Filtrovať
            </button>
          </div>
          <div v-else class="flex justify-start">
            <button @click="clickedFilter = !clickedFilter" class="float-left px-4 whitespace-no-wrap py-2 bg-gray-200 hover:bg-gray-300 hover:text-gray-50 shadow-lg hover:shadow-xs focus:outline-none rounded text-sm text-gray-500">
              <span class="text-sm">Upraviť filter</span> 
                <font-awesome-icon :icon="['fas', 'pencil-alt']" class="ml-2" />
            </button>
          </div>
        </div>

      <!-- Categories -->
          <div class="flex flex-wrap">
            <div v-for="category in showedCategories" :key="category.index" class="p-1 text-xs text-black whitespace-no-wrap">
              <button class="transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110" @click="removeCategory(category)">
                <span class="flex items-center justify-between bg-white hover:bg-gray-200 hover:text-red-600 bg-opacity-25 hover:text-bold p-1 rounded center">
                  {{ category.branch.name }}
                  <span class="font-bold text-md ml-1">X</span>
                </span>
              </button>
            </div>
          </div>
      </div>

  </div>
</template>

<script>
import {mapState, mapGetters} from 'vuex'

export default {
    name: 'FilterNav',

    props: {
        store: {}
    },

    data: () => ({
        filter: {
            sortByUnread: Boolean,
            filterByBranch: [],
        },
        clickedFilter: false,
        removedCategories: [],
    }),

    async fetch() {
        await this.$store.dispatch('branches/getNotPaginatedList')
    },

    computed: {
        ...mapState({
            authUser: state => state.auth.user,
            notPaginatedBranches: state => state.branches.notPaginatedBranches.data,
        }),
        ...mapGetters({
            tab: 'dashboardTab/tab',
            filtratedMessages: 'contactForm/messages'
        }),
        showedCategories() {
          if(this.filtratedMessages.data) {
            return this.uniqByForeignKey(this.filtratedMessages.data, message => message.branch_id);
          }
        }
    },

    methods: {
        // Remove Duplicated Categories
        uniqByForeignKey(data, key) {
            return [
              ...new Map(
                data.map(x => [key(x), x])
              ).values()
            ]
        },

        sortByUnread() {
            this.unread = ! this.unread;
            this.$emit('sortByUnread', this.unread);
        },

        removeCategory(category) {
          let categoryObjs = this.showedCategories.filter(cat => cat.branch_id != category.branch_id);

          this.filter.filterByBranch = categoryObjs.map(cat => cat.branch_id);
          
          this.$emit('filterByBranch', this.filter.filterByBranch);
          // const index = this.removedCategories.indexOf(category);

          // // if( index > -1 ) {
          //  let founded = this.removedCategories.splice(index, 1);
           
          //  this.filterList(463)
          // let foundIds = this.filtratedMessages.data.filter(message => message.branch_id == category.branch_id)
          //   this.removedCategories.filter((category, index) => this.removedCategories.splice())
            // this.filterList(this.filter.filterByBranch);
          // }

          // let removedCategories = this.showedCategories.filter(category => category.branch_id == category.branch_id);
          // console.log(founded)

        },
       
        filterList(id) {
            if(this.filter.filterByBranch){
                var idExists = this.filter.filterByBranch.find(branchId => branchId == id);
            }

            if(idExists !== undefined) {
                let unduplicatedIds = this.filter.filterByBranch.filter(branchId => branchId != id);
                this.filter.filterByBranch = unduplicatedIds;
                this.$emit('filterByBranch', this.filter.filterByBranch);
            } else {
                this.filter.filterByBranch.push(id);
                this.$emit('filterByBranch', this.filter.filterByBranch);
            }
        },

        async cancelFilter() {
         this.clickedFilter = false;
          this.filter.sortByUnread = false;
          this.filter.filterByBranch = [];
          await this.$store.dispatch(this.store + '/getList', { pageNumber: 0, sortByUnread: this.filter.sortByUnread, filterByBranch: this.filter.filterByBranch});
        }
    }
}
</script>
<style scoped>
.yellow--text /deep/ label {
    color: #fff7d1;
    font-size: 0.8em;
    padding: 0 !important;
}

.v-application v-radio {
  background-color: #00a86b;
}

</style>