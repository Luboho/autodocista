export const state = () => ({
    users: {},
    allUsers: {}
})

export const mutations = {
    SET_USERS(state, value) {
        state.users = value
    },
    SET_CURRENT_PAGE(state, data) {
        state.users.meta.current_page = data;
    },
    REMOVE_USER: (state, id) => (state.users.data = state.users.data.filter(user => user.id !== id)),
    SET_ALL_USERS(state, value) {
        state.allUsers = value;
    }
}

export const actions = {

    async getList({commit}, {pageNumber, sortByUnread, filterByCategory}) {
        this.dispatch('spinner/setSpinner', true, { root: true });
        try {
            await this.$axios.$get('sanctum/csrf-cookie');

            let resp = await this.$axios.get(`/api/users?page=${pageNumber}&unreadMsgs${sortByUnread}&branch_id=${filterByCategory}`)
            .then(function(resp) {
                commit('SET_USERS', resp.data)
            })
        } catch (e) {
            console.log(e);
        }
        this.dispatch('spinner/setSpinner', false, { root: true });
    },
    async deleteUser({commit}, id) {
        try {
            await this.$axios.$get('sanctum/csrf-cookie');
            await this.$axios.delete(`/api/users/${id}`)
                .then(commit('REMOVE_USER', id))
        } catch (e) {
            console.log(e);
        }
    },
    async getAllUsers({commit}) {
        try {
            await this.$axios.$get('sanctum/csrf-cookie');

            let resp = await this.$axios.get('api/all-users')
                .then(function(resp) {
                    commit('SET_ALL_USERS', resp.data)
                });
        } catch (e) {
            console.log(e);
        }
      this.dispatch('spinner/setSpinner', false, { root: true });
    }
}