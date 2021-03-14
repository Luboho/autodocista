export const state = () => ({
    branches: [],
  })
  
  export const mutations = {
    SET_BRANCHES(state, value) {
      state.branches = value
    }
  }
  
  export const actions = {
    async getBranches({commit}) {

        try {
            await this.$axios.$get('sanctum/csrf-cookie');

            let resp = await this.$axios.get('/api/get-branches')
            .then(function(resp) {
                commit('SET_BRANCHES', resp.data.data)
            })
        } catch (e) {
            console.log(e);
        }
    },
  }
