export const state = () => ({
    loading: true,
})

export const mutations = {
    setLoading(state, value) {
        state.loading = value
    }
}

export const actions = {
    async isLoading({commit, boolean}) {
       commit('setloading', boolean)
    }
}