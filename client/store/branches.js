export const state = () => ({
    branches: {},
    notPaginatedBranches: {},
    branchForEdit: {}
  })
  
  export const mutations = {
    SET_BRANCHES(state, value) {
      state.branches = value
    },
    SET_NOT_PAGINATED(state, value) {
      state.notPaginatedBranches = value
    },

    SET_BRANCH_FOR_EDIT(state, value) {
      state.brachForEdit = value
    },
    
    SET_CURRENT_PAGE(state, data) {
      state.branches.meta.current_page = data;
    },
    REMOVE_BRANCH: (state, id) => (state.branches.data = state.branches.data.filter(branch => branch.id !== id))
  }
  
  export const actions = {
    async getList({commit}, {pageNumber}) {
      this.dispatch('spinner/setSpinner', true, { root: true });
        try {
            await this.$axios.$get('sanctum/csrf-cookie');

            let resp = await this.$axios.get(`/api/branches?page=${pageNumber}`)
            .then(function(resp) {
                commit('SET_BRANCHES', resp.data)
            })
        } catch (e) {
            console.log(e);
        }
      this.dispatch('spinner/setSpinner', false, { root: true});
    },

    // Calls FilterNav.vue
    async getNotPaginatedList({commit}) {
      try {
        await this.$axios.$get('sanctum/csrf-cookie');
        
        let resp = await this.$axios.get(`/api/branches?all-branches=${true}`)
        .then(function(resp) {
          commit('SET_NOT_PAGINATED', resp.data);
        })
      } catch (e) {
        console.log(e);
      }
    },
    
    async getSelected({commit}, id) {
      this.dispatch('spinner/setSpinner', true, { root: true });
      try {
        await this.$axios.$get('sanctum/csrf-cookie');
        let resp = await this.$axios.post(`/api/branches/${id}`)
          .then(function(resp) {
            commit('SET_BRANCHES', resp.data)
          })
      } catch (e) {
        console.log(e);
      }
      this.dispatch('spinner/setSpinner', false, { root: true });
    },

    async deleteBranch({commit}, id) {
      try {
        await this.$axios.$get('sanctum/csrf-cookie');
        await this.$axios.delete(`/api/branches/${id}`)
          .then(commit('REMOVE_BRANCH', id))
      } catch (e) {
          console.log(e);
      }
    }
  }
