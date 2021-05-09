export const state = () => ({
    modal: false,
})

export const mutations = {
    setModal(state, value) {
        state.modal = value
    }
}

export const actions = {
    async changeModal({commit}, boolean) {
       commit('setModal', boolean)
    }
}