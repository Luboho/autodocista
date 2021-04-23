export const state = () => ({
    branches: {},
  })
  
  export const mutations = {
    SET_BRANCHES(state, value) {
      state.branches = value
    },
    SET_CURRENT_PAGE(state, data) {
      state.branches.meta.current_page = data;
    },
    SET_LOADING(state){
      state.loading = false
    },
    REMOVE_BRANCH: (state, id) => (state.branches = state.branches.filter(branch => branch.id !== id))
  }
  
  export const actions = {
    async getList({commit}, pageNumber) {

        try {
            await this.$axios.$get('sanctum/csrf-cookie');

            let resp = await this.$axios.get('/api/branches?page=' + pageNumber)
            .then(function(resp) {
                commit('SET_BRANCHES', resp.data)
                })
        } catch (e) {
            console.log(e);
        }
    },

    async deleteBranch({commit}, id) {
      try {
        await axios.delete(`/api/branches/${id}`)
          .then(commit('REMOVE_BRANCH', id))
      } catch (e) {
          console.log(e);
      }
    }
  }
