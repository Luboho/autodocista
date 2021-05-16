<template>
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
    name: "Pagination",
    // props: ['store', 'collection', 'filter'],
    props: {
      store: {},
      collection: {},
      filter: {
            sortByUnread: false,
            filterByBranch: []
        }
    },

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
      this.$store.dispatch(this.store + '/getList', { pageNumber: pageNumber, sortByUnread: this.filter.sortByUnread, filterByBranch: this.filter.filterByBranch});
      this.scrollToTopSmooth();
    },

    scrollToTopSmooth() {
      return window.scrollTo({
        top: 180, 
        behavior: 'smooth'
      });
    }
  }
}
</script>