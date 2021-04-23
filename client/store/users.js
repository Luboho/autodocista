export const state = () => ({
    users: {},
})

export const mutations = {
    SET_USERS(state, value) {
        state.users = value
    },
    SET_CURRENT_PAGE(state, data) {
        state.users.meta.current_page = data;
    },
    REMOVE_USER: (state, id) => (state.users = state.users.filter(user => user.id !== id))
}

export const actions = {
    async getList({commit}, pageNumber) {
        
        try {
            
            await this.$axios.$get('sanctum/csrf-cookie');

            let resp = await this.$axios.get('/api/users?page=' + pageNumber)
            .then(function(resp) {
                commit('SET_USERS', resp.data)
                commit('loading/setLoading', false, { root: true })
               })
        } catch (e) {
            console.log(e);
        }
    },
    async deleteUser({commit}, id) {
        try {
            await this.$axios.delete(`/api/users/${id}`)
                .then(commit('REMOVE_USER', id))
        } catch (e) {
            console.log(e);
        }
    },
}