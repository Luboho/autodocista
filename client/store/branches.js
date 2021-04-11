export const state = () => ({
    branches: [],
    loading: true
  })
  
  export const mutations = {
    SET_BRANCHES(state, value) {
      state.branches = value
    },
    SET_LOADING(state){
      state.loading = false
    }
  }
  
  export const actions = {
    async getBranches({commit}) {

        try {
            await this.$axios.$get('sanctum/csrf-cookie');

            let resp = await this.$axios.get('/api/branches')
            .then(function(resp) {
                commit('SET_BRANCHES', resp.data.data)
                commit('SET_LOADING', false)
            })
        } catch (e) {
            console.log(e);
        }
    },
  }
