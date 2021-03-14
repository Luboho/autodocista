export const state = () => ({
    modal: false,
})

export const mutations = {
    SET_MODAL(state, value) {
        state.modal = value
    }
}

export const actions = {
    changeModal({commit, boolean}) {
       commit('SET_MODAL', boolean)
    }
}