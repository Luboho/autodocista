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
    REMOVE_USER: (state, id) => (state.users.data = state.users.data.filter(user => user.id !== id))
}

export const actions = {

        async getList({commit}, pageNumber) {
            // this.dispatch('spinner/setSpinner', true, { root: true });
            if(pageNumber == undefined) {
              pageNumber = 0;
            }
            try {
                await this.$axios.$get('sanctum/csrf-cookie');
    
                let resp = await this.$axios.get('/api/users?page=' + pageNumber)
                .then(function(resp) {
                    commit('SET_USERS', resp.data)
                })
            } catch (e) {
                console.log(e);
            }
            // this.dispatch('spinner/setSpinner', false, { root: true });
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
}