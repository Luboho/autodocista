export const state = () => ({
    messages: {},
  })
  
  export const mutations = {
    SET_MESSAGES(state, value) {
      state.messages = value
    },
    SET_CURRENT_PAGE(state, data) {
      state.messages.meta.current_page = data;
  },
  }
  
  export const actions = {
    async getList({commit}, pageNumber) {

        try {
          
          await this.$axios.$get('sanctum/csrf-cookie');
          
          let resp = await this.$axios.get('/api/messages?page=' + pageNumber)
          .then(function(resp) {
                commit('loading/setLoading', true, { root: true })
                commit('SET_MESSAGES', resp.data)
                commit('loading/setLoading', false, { root: true })
               })
        } catch (e) {
            console.log(e);
        }
    },
  }
