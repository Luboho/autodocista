export const state = () => ({
    messages: {},
    // notificationNum: 0
  })

  export const getters = {
    messages (state) {
        return state.messages
    },
    notificationNum (state) {
      return state.notificationNum
    }
  }
  
  export const mutations = {
    SET_MESSAGES(state, value) {
      state.messages = value
    },
    SET_CURRENT_PAGE(state, data) {
      state.messages.meta.current_page = data;
    },
    SET_NOTIFICATIONS_NUM(state, value) {
      state.notificationNum = value
    }
  }
  
  export const actions = {

    async getList({commit}, {pageNumber, sortByUnread, filterByBranch}) {
      await this.dispatch('spinner/setSpinner', true, { root: true })
      try {
        
        await this.$axios.$get('sanctum/csrf-cookie');
        
        let resp = await this.$axios.get(`/api/messages?page=${pageNumber}&unreadMsgs=${sortByUnread}&branch_id=${filterByBranch}`)
        .then(function(resp) {
                commit('SET_MESSAGES', resp.data)
        })
        } catch (e) {
            console.log(e);
        }
        // await this.dispatch('spinner/setSpinner', false, { root: true })
    },

    async getNotificationsNum({commit}) {
      try {
        await this.$axios.$get('sanctum/csrf-cookie');

        let resp  = await this.$axios.get('/api/notifications-num')
          .then(function(resp){
            commit('SET_NOTIFICATIONS_NUM', resp.data.data[0]);
          });
      } catch (e) {
          console.log(e);
      }
    }

  }
