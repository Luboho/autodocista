export const state = () => ({
    tab: 'messages',
})

export const getters = {
    tab (state) {
        return state.tab
    }
}

export const mutations = {
    SET_TAB(state, value) {
        state.tab = value
    }
}

export const actions = {
    changeTab({commit, value}) {
       commit('SET_TAB', value)
    }
}