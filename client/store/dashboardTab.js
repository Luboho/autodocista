export const state = () => ({
    tab: 'messages',
})

export const getters = {
    tab (state) {
        return state.tab
    }
}

export const mutations = {
    setTab(state, value) {
        state.tab = value
    }
}

export const actions = {
    changeTab({commit, value}) {
       commit('setTab', value)
    }
}