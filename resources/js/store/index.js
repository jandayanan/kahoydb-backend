import { createStore } from 'vuex'

export default createStore({
  state: {
    sidebarVisible: '',
    sidebarUnfoldable: false,
    isReloading: false,
    hasNewData: false,
    activityOutputTabPaneKey: 1,
    showActivityModal: false,
    showActivityOutputModal: false,
    showParticipantInfoModal: false,
    showParticipantInsertModal: false,
    showParticipantUpsertModal: false,
    showTreeUpsertModal: false,
    showEntityUpsertModal: false,
    showOrganizationInfoModal: false,
    showOrganizationUpsertModal: false,
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
    setActivityOutputTabPaneKey(state, payload) {
      state.activityOutputTabPaneKey = payload
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
    updateParticipantUpsertModalState(state, payload) {
      state.showParticipantUpsertModal = payload
    },
    updateOrganizationInfoModalState(state, payload) {
      state.showOrganizationInfoModal = payload
    },
    updateOrganizationUpsertModalState(state, payload) {
      state.showOrganizationUpsertModal = payload
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
