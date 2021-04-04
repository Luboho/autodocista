export const state = () => ({
    messages: [],
  })
  
  export const mutations = {
    SET_MESSAGES(state, value) {
      state.messages = value
    }
  }
  
  export const actions = {
    async getMessages({commit}) {

        try {
            await this.$axios.$get('sanctum/csrf-cookie');

            let resp = await this.$axios.get('/api/get-messages')
            .then(function(resp) {
                commit('SET_MESSAGES', resp.data.data)
            })
        } catch (e) {
            console.log(e);
        }
    },
  }
