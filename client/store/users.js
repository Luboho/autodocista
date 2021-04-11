export const state = () => ({
    users: [],
    loading: true
});

export const mutations = {
    SET_USERS(state, value) {
        state.users = value
    },
    SET_LOADING(state, value) {
        state.loading = false
    }
}

export const actions = {
    async getUsers({commit}) {

        try {
            await this.$axios.$get('sanctum/csrf-cookie');
            let resp = await this.$axios.get('/api/users')
            .then(function(resp) {
                commit('SET_USERS', resp.data.data),
                commit('SET_LOADING', false)
            })
        } catch (e) {
            console.log(e);
        }
    },
}