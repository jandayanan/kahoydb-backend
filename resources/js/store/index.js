import { createStore } from 'vuex'

export default createStore({
  state: {
    sidebarVisible: '',
    sidebarUnfoldable: false,
    isReloading: false,
    hasNewData: false,
    showActivityModal: false,
    showActivityOutputModal: false,
    showParticipantInfoModal: false,
    showParticipantInsertModal: false,
    showTreeUpsertModal: false,
    showEntityUpsertModal: false,
    showDeleteModal: false,
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
    updateActivityModalState(state, payload) {
      state.showActivityModal = payload
    },
    updateActivityOutputModalState(state, payload) {
      state.showActivityOutputModal = payload
    },
    updateParticipantInfoModalState(state, payload) {
      state.showParticipantInfoModal = payload
    },
    updateParticipantInsertModalState(state, payload) {
      state.showParticipantInsertModal = payload
    },
    updateTreeUpsertModalState(state, payload) {
      state.showTreeUpsertModal = payload
    },
    updateEntityUpsertModalState(state, payload) {
      state.showEntityUpsertModal = payload
    },
    updateDeleteModalState(state, payload) {
      state.showDeleteModal = payload
    }
  },
  actions: {},
  modules: {},
})
