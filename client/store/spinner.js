export const state = () => ({
    spin: false,
})

export const mutations = {
    SET_SPINNER(state, value) {
        state.spin = value;
    }
}

export const actions = {
    async setSpinner({commit}, boolean) {
        commit('SET_SPINNER', boolean)
        await this.dispatch('modal/changeModal', boolean, {root:true})
    }
}