import { createStore } from 'vuex'

export default createStore({
  state: {
    sidebarVisible: '',
    sidebarUnfoldable: false,
    isReloading: false,
    hasNewData: false,
    showParticipantInfoModal: false
  },
  mutations: {
    updateNewDataStatus(state, status) {
      state.hasNewData = status
    },
    toggleReload(state) {
      state.isReloading = !state.isReloading
    },
    toggleSidebar(state) {
      state.sidebarVisible = !state.sidebarVisible
    },
    toggleUnfoldable(state) {
      state.sidebarUnfoldable = !state.sidebarUnfoldable
    },
    updateSidebarVisible(state, payload) {
      state.sidebarVisible = payload.value
    },
    updateParticipantInfoModalState(state, payload) {
      state.showParticipantInfoModal = payload
    }
  },
  actions: {},
  modules: {},
})
