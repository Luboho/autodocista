<template>
  <div>
    <!-- Filter Window -->
      <div v-if="filterWinActive"
        class="absolute z-50 left-0 right-0 flex justify-center">

        <div class="relative z-30 w-80 rounded-md bg-gray-300 px-5">
          <!-- Buttons -->
          <div class="sticky flex center justify-center py-4 z-50">
            <button @click="cancelFilter" class="text-gray-400 mr-3 bg-gold-200 hover:bg-gold-300 focus:outline-none shadow-lg hover:shadow-xs rounded pr-4 px-4 py-2 text-sm">
              Zrušiť
              <font-awesome-icon :icon="['fas', 'window-close']" class="ml-2 text-red-500 hover:text-red-600" />
            </button>
              <button @click="runFilter(undefined)"  v-if="true" class="px-4 py-2 ml-3 bg-gold-500 hover:bg-gold-400 shadow-lg hover:shadow-xs focus:outline-none rounded text-sm font-bold text-gray-700">
                  Zobraziť
                  &nbsp;
                  <span class="font-light">({{ countAllMsgsQty() }})</span>
                  <!-- ( {{ checkedItems.length > 0 ? checkedItems.length : null }} ) -->
              </button>
             <button v-else @click="runFilter(undefined)"  disabled="disabled" class="border disabled:border-gray-900 px-4 py-2 ml-3 rounded text-sm text-gray-700">
                Zobraziť
             </button>
          </div>

            <div class="py-2 ml-2">
              <label class="custom-checkbox-container text-gray-900 font-semibold cursor-pointer bold uppercase">
                <input v-model="filter.unread" type="checkbox" name="" id="">
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

            <div class=" border-t border-gray-400 font-semibold  p-1 overflow-y-scroll bg-gray-300 max-h-250px">
              <form v-for="category in showedCategories" :key="category.id" class="px-1">
                  <label class="custom-checkbox-container w-64 pb-4 text-gray-900 cursor-pointer">
                    <input 
                        type="checkbox"
                        name="category"
                        :value="category.id"
                        v-model="filter.checkedCategories">
                        <div class="flex justify-between">
                          <div  class="mt-0.5 font-light">{{ category.name }}</div>
                          <div class="font-light" v-if="showedCategories">({{ countMsgsForEach(category.id) }}) </div> 
                        </div>
                      <span class="checkmark"></span>
                  </label>
              </form>
            </div>
        </div>
      </div>
    <!-- End of Filter Window -->

      <div class="flex">
        <!-- Filter Button -->
        <div class="mb-4 mx-2 float-right">
          <div v-if="filterIsActive">
            <button @click="openFilterMenu" 
                    class="float-left px-4 whitespace-no-wrap py-2 bg-gray-200 hover:bg-gray-300 hover:text-gray-50 shadow-lg hover:shadow-xs focus:outline-none rounded text-sm text-gray-500">
              <span class="text-sm">Upraviť filter</span>
                <font-awesome-icon :icon="['fas', 'pencil-alt']" class="ml-2" />
            </button>
          </div>
          <div v-else class="flex justify-start">
            <button @click="openFilterMenu" class="transition duration-300 ease-in-out px-4 py-2 bg-gray-200 hover:bg-gray-300 hover:text-gray-50 shadow-lg hover:shadow-xs focus:outline-none rounded text-sm text-gray-500">
              Filtrovať 
            </button>
          </div>
        </div>

      <!-- Categories in this case Categories are Branches related to Messages & Users also. -->
          <div class="flex flex-wrap">
            <div v-for="cat in showedCategories" :key="cat.index" class="mx-1 mb-1 text-xs text-black whitespace-no-wrap">
              <button class="transition duration-500 ease-in-out transform hover:scale-90"
                      @click="runFilter(cat.id)"
              >
                <span class="category-btn flex items-center justify-between bg-gray-200 hover:font-bold hover:bg-opacity-50 p-1 rounded center"
                      :class="{'bg-gold-400' : filter.checkedCategories.includes(cat.id)}">
                  {{cat.name}}
                </span>
              </button>
            </div>
          </div>
      </div>
    <Modal />
  </div>
</template>

<script>
import {mapState, mapMutations, mapGetters, mapActions} from 'vuex'
import Modal from './Modal'

export default {
    name: 'FilterNav',

    props: ['store', 'dataList', 'allMessages', 'allUsers'],

    data: () => ({
        filter: {
            unread: false,
            checkedCategories: [],
        },
        filterWinActive: false,
        filterIsActive: false,
    }),

    computed: {
        ...mapState({
            modal: state => state.modal.modal,
            categories: state => state.branches.notPaginatedBranches.data, // Branches bcs. are related to Msgs and Users also.
        }),
        ...mapGetters({
            tab: 'dashboardTab/tab',
        }),
        showedCategories() {
          if(this.notPagList) {
            // Return Only the Categories which contain at least one item.
            return this.categories.filter(cat => this.notPagList.some(item => cat.id == item.branch_id))
          }
        },
        notPagList() {
          if(this.store === "users"){
            return this.allUsers;
          } else if(this.store === "contactForm") {
            return this.allMessages;
          } 
        },
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
        ...mapMutations({
             setModal : 'modal/setModal',
        }),
        ...mapActions({
          setSpinner : 'spinner/setSpinner',
        }),

        openFilterMenu() {
          this.setCheckedCategories();
          this.filterWinActive = true;
        },

        setCheckedCategories() {
          // if(this.checkedCategories == undefined){
          //   this.filter.checkedCategories = this.showedCategories.map((showedCat) => showedCat.id);
          // }    
          const checked = this.dataList.map((item) => parseInt(item.branch_id));
          this.filter.checkedCategories = checked.filter((value, index) => checked.indexOf(value) === index);
        },

        markChecked(id) {
          if(id){
            this.showedCategories.map(function(cat) {
              if(cat.id === id) {
                return true;
              }
            })
          }
        },

       countMsgsForEach(id) {
          const qty = this.notPagList.filter(item => item.branch_id == id);
          return qty.length;
      },

      countAllMsgsQty() {
          const findCategoryById = this.notPagList.map((item) => this.filter.checkedCategories.filter(cat => cat == item.branch_id));
         const ids = findCategoryById.map((el) => el[0] )
         let counted = this.count_duplicate(ids);
         let vals = ids.filter(function(val) {
           if(val != undefined) {
             return true;
           } else {
             return false
           }
         }).length
         return vals;
       },

       count_duplicate(a){
        let counts = []

        for(let i =0; i < a.length; i++){ 
          if (counts[a[i]]){
          counts[a[i]] += 1
          } else {
          counts[a[i]] = 1
          }
        }
        return counts;  
      },

      // },
      //   chooseFilter() {
      //     // Call All Msgs bcs of counting of each msg by branch.
      //     // this.allMessages;
      //     this.checkedItems = this.filtratedCategories.data;
      //     this.filterWinActive = true;

      //     //notPaginatedBranches ids array
      //     let allItemsArr = this.allItems.map(function(item) {
      //       return item.id;
      //     });

      //     // All msgs branch_id array
      //     let showedCategoriesIdArr = this.notPaginatedBranches.map(function(item) {
      //       return item.branch_id;
      //     });

      //     // Make an Array of checked categories
      //     const unduplicateMyValues = showedCategoriesIdArr.map(function(branch_id) {  // branch_id is a foreign key
      //       const checked = allItemsArr.filter(item_id => item_id == branch_id);
      //       return checked[0];
      //     });
      //     // Unduplicate values
      //     this.filter.checkedCategories = this.unduplicate(unduplicateMyValues);
      //   },

        runFilter(id) {
          if(id != undefined){
            this.filter.checkedCategories = [];
            this.filter.checkedCategories.push(id)
            this.filter.unread = false;
            this.$emit('sortByUnread', this.filter.unread);
            this.$emit('filterByCategory', this.filter.checkedCategories);
          } else {
            this.$emit('sortByUnread', this.filter.unread);
            this.$emit('filterByCategory', this.filter.checkedCategories);
          }
          this.filterIsActive = true;
        },

        async cancelFilter() {
          this.filterWinActive = false;
          this.setModal(false);
          this.filter.unread = false;
          this.filter.checkedCategories = [];
          this.filterIsActive = false;
          await this.$store.dispatch(this.store + '/getList', { pageNumber: 0, sortByUnread: this.filter.unread, filterByCategory: this.filter.checkedCategories});
        },

        unduplicate(arr){
          if(arr !== undefined) {
            return arr.filter((item, index) => arr.indexOf(item) == index);
          }
        },
    },

    watch: {
      filterWinActive: {
        handler(newVal, oldVal){
          if(newVal == true) {
              this.setModal(true);
          } else {
            this.setModal(false);
          }
        },
      },
      modal: {
        handler(newVal, oldVal){
          if(newVal == false) {
            this.filterWinActive = false;
          }
        }
      },
    },

    components: {
      Modal
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

.category-btn:hover:after {
  position: absolute;
  content: "\2705";
  font-size: 3em;
  color: #fde047;
  text-shadow: 1px 1px 1px whitesmoke;
  right: 0;
  left: 0;
}

</style>