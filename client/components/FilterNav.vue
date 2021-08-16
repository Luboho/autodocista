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
              <button @click="filterByCategory(undefined)"  v-if="true" class="px-4 py-2 ml-3 bg-gold-500 hover:bg-gold-400 shadow-lg hover:shadow-xs focus:outline-none rounded text-sm font-bold text-gray-700">
                  Zobraziť
                  &nbsp;
                  ( {{ checkedMsgs.length > 0 ? checkedMsgs.length : null }} )
              </button>
             <button v-else @click="filterByCategory(undefined)"  disabled="disabled" class="border disabled:border-gray-900 px-4 py-2 ml-3 rounded text-sm text-gray-700">
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
              <form v-for="item in notPaginatedItems" :key="item.id" class="px-1">
                  <label class="custom-checkbox-container w-64 pb-4 text-gray-900 cursor-pointer">
                    <input @click="countAllMsgsQty(item.id)"
                        type="checkbox"
                        name="item"
                        :value="item.id"
                        v-model="filter.checkedCategories">
                        <div class="flex justify-between">
                          <div  class="mt-0.5 font-light">{{ item.name }}</div>
                          <div v-if="allMessages">({{ countMsgsForEach(item.id) }}) </div>
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
            <button @click="selectCategory" class="float-left px-4 whitespace-no-wrap py-2 bg-gray-200 hover:bg-gray-300 hover:text-gray-50 shadow-lg hover:shadow-xs focus:outline-none rounded text-sm text-gray-500">
              <span class="text-sm">Upraviť filter</span>
                <font-awesome-icon :icon="['fas', 'pencil-alt']" class="ml-2" />
            </button>
          </div>
          <div v-else class="flex justify-start">
            <button @click="selectCategory" class="transition duration-300 ease-in-out px-4 py-2 bg-gray-200 hover:bg-gray-300 hover:text-gray-50 shadow-lg hover:shadow-xs focus:outline-none rounded text-sm text-gray-500">
              Filtrovať
            </button>
          </div>
        </div>

      <!-- Categories -->
          <div class="flex flex-wrap">
            <div v-for="category in showedCategories" :key="category.index" class="mx-1 mb-1 text-xs text-black whitespace-no-wrap">
              <button class="transition duration-500 ease-in-out transform hover:scale-90"
              @click="filterByCategory(category.branch_id)">
                <span class="category-btn flex items-center justify-between bg-gray-200 hover:font-bold hover:bg-opacity-50 p-1 rounded center">
                  {{ category.branch.name }}
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

    props: ['store', 'dataList', 'notPaginatedItems'],

    data: () => ({
        filter: {
            unread: false,
            checkedCategories: [],
        },
        filterWinActive: false,
        filterIsActive: false,
        removedCategories: [],
        checkedMsgs: []
    }),

    async fetch() {
        await this.$store.dispatch('branches/getNotPaginatedList')
    },

    computed: {
        ...mapState({
            authUser: state => state.auth.user,
            modal: state => state.modal.modal,
            // notPaginatedBranches: state => state.branches.notPaginatedBranches.data,
            messages: state => state.contactForm.messages.data,
            allMessages: state => state.contactForm.allMessages.data
        }),
        ...mapGetters({
            tab: 'dashboardTab/tab',
            filtratedItems: 'contactForm/messages'
        }),
        showedCategories() {
          if(this.dataList) {
            return this.uniqByForeignKey(this.dataList, message => message.branch_id);
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
          getAllMsgs: 'contactForm/getAllMessages'
        }),

       countMsgsForEach(id) {
          const qty = this.allMessages.filter(msg => msg.branch_id == id);
          return qty.length;
      },

      countAllMsgsQty(id) {
        const idExists = this.checkedMsgs.filter(el => el.branch_id == id)
        
        if(idExists[0] != undefined){
          // REmove obj If exists
          this.checkedMsgs.forEach((el) => {
            if(el.branch_id == id) {
              this.checkedMsgs = this.checkedMsgs.filter(msg => msg.branch_id != id);
            } 
          });
        } else {
          // Push Msg without Arr's Bracket to CheckedMsgs
          const arrOfMsgs = this.allMessages.filter(msg => msg.branch_id == id);
          arrOfMsgs.forEach(el => {this.checkedMsgs.push(el)})
        }

      },
        selectCategory() {
          // Call All Msgs bcs of counting of each msg by branch.
          this.getAllMsgs();
          this.checkedMsgs = this.filtratedItems.data;
          this.filterWinActive = true;

          //notPaginatedBranches ids array
          let notPaginatedItemsArr = this.notPaginatedItems.map(function(branch) {
            return branch.id;
          });

          // All msgs branch_id array
          let showedMsgBranchIdArr = this.messages.map(function(msg) {
            return msg.branch_id;
          });

          // Make an Array of checked categories
          const unduplicateMyValues = showedMsgBranchIdArr.map(function(branch_id) {
            const checked = notPaginatedItemsArr.filter(msg_id => msg_id == branch_id);
            return checked[0];
          });
          // Unduplicate values
          this.filter.checkedCategories = this.unduplicate(unduplicateMyValues);
        },

        filterByCategory(category) {
          if(category != undefined){
            this.$emit('sortByUnread', this.filter.unread);
            this.$emit('filterByBranch', category);
          } else {
            this.$emit('sortByUnread', this.filter.unread);
            this.$emit('filterByBranch', this.filter.checkedCategories);
          }
          this.filterIsActive = true;
        },

        async cancelFilter() {
          this.filterWinActive = false;
          this.setModal(false);
          this.filter.unread = false;
          this.filter.checkedCategories = [];
          this.filterIsActive = false;
          await this.$store.dispatch(this.store + '/getList', { pageNumber: 0, sortByUnread: this.filter.unread, filterByBranch: this.filter.checkedCategories});
        },

        unduplicate(arr){
          if(arr !== undefined) {
            return arr.filter((item, index) => arr.indexOf(item) == index);
          }
        }
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