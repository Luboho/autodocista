export const state = () => ({
    messages: [],
    loading: true
  })
  
  export const mutations = {
    SET_MESSAGES(state, value) {
      state.messages = value
    },
    SET_LOADING(state){
      state.loading = false
    }
  }
  
  export const actions = {
    async getMessages({commit}) {

        try {
            await this.$axios.$get('sanctum/csrf-cookie');

            let resp = await this.$axios.get('/api/messages')
            .then(function(resp) {
                commit('SET_MESSAGES', resp.data.data)
                commit('SET_LOADING', false)
            })
        } catch (e) {
            console.log(e);
        }
    },
  }
