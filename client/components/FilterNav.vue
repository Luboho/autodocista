<template>
  <div>
      <v-container fluid>
          <v-row>
                <v-checkbox @click="sortByUnread"
                            class="yellow--text px-2 mr-4 bold uppercase"
                            label="Neprečítané"
                            color="#fee97e"
                >
                </v-checkbox>
              <div v-show="authUser.is_admin == '1'" 
                   v-for="branch in branches" 
                   :key="branch.index" 
                   class="yellow--text px-2 text-xs">
                <v-checkbox
                            color="#fee97e"
                            @click="filterList(branch.id)"
                            :label="branch.name"
                            :dense="true"
                            :value="branch.id"
                >
                </v-checkbox>
              </div>
          </v-row>
      </v-container>
  </div>
</template>

<script>
import {mapState} from 'vuex'
export default {
    name: 'FilterNav',
    data: () => ({
        filter: {
            sortByBranch: [],
            unread: false
        }
    }),

    computed: {
        ...mapState({
            authUser: state => state.auth.user,
            branches: state => state.branches.branches.data,
        }),
    },

    methods: {
        sortByUnread() {
            this.unread = ! this.unread;
            this.$emit('sortByUnread', this.unread);
        },
       
        filterList(id) {
            if(this.filter.sortByBranch){
                var idExists = this.filter.sortByBranch.find(branchId => branchId == id);
            }

            if(idExists !== undefined) {
                let removedIdArr = this.filter.sortByBranch.filter(branchId => branchId != id);
                this.filter.sortByBranch = removedIdArr;
                this.$emit('filterByBranch', this.filter.sortByBranch);
            } else {
                this.filter.sortByBranch.push(id);
                this.$emit('filterByBranch', this.filter.sortByBranch);
            }
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

</style>