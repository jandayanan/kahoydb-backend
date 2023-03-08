<template>
  <div>
    <CButton color="success" class="mb-3" @click="showCreateModal">Add Organization</CButton>
    <OrganizationsTable 
      :items="items" 
      :permission="'write'"
      @updateSelectedRow="showUpdateModal"
      @deleteSelectedRow="showDeleteModal"
      @selectedRow="showInfoModal" />
    <OrganizationInfoModal 
      :organization="modalData" />
    <OrganizationUpsertModal 
      :organization="organization"
      :method="formMethod" />
    <DeleteModal 
      :entityId="entityId"
      :entityName="entityName"
      :entityType="entityType" />
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { getAllOrganizations } from '@/service/api'
import OrganizationInfoModal from './OrganizationInfoModal.vue'
import OrganizationsTable from './OrganizationsTable.vue'
import OrganizationUpsertModal from './OrganizationUpsertModal.vue'
import DeleteModal from '@/Components/DeleteModal.vue'

export default {
  name: 'ParticipantsContent',
  components: {
    OrganizationInfoModal,
    OrganizationsTable,
    OrganizationUpsertModal,
    DeleteModal
  },  
  data(){
    return {
      items: [], 
      filters: {
        name: {
          value: '',
          keys: ['full_name', 'organization.organization_type']
        }
      },
      organization: {},
      modalData: [],
      formMethod: 'create',
      entityId: null,
      entityName: null,
      entityType: null
    }
  },
  mounted(){
    this.getOrganizations()
  },
  methods: {
    getOrganizations(){
      // Toggle loading state 
      this.$store.commit('toggleReload')

      getAllOrganizations(`
        relations[3]=sponsors&
        relations[4]=activities.trees.planter&
        relations[5]=activitiesSub.trees.planter&
        relations[6]=parentOrganization.entity`)
      .then(res => {
        
        this.items = res.data.data.organizations
        this.items = this.items.map(item => {
          var trees = []
          let organizationObj = {
            organization: {
              id: item.id,
              parent_organization_id: item.parent_organization_id,
              parent_organization_name: _.get(item.parent_organization, 'entity.full_name', null),
              organization_type: item.organization_type,
              organization_status: item.organization_status
            },
            ...item.entity
          }

          if(item.parent_organization_id){
            organizationObj['activities'] = item.activities_sub
          } else {
            organizationObj['activities'] = item.activities
          }
          organizationObj.activities.forEach(activity => {
            trees = trees.concat(activity.trees)

          })

          organizationObj['trees'] = trees
          organizationObj['treesCount'] = trees.filter(tree => tree.tree_status == 'Planted').length

          return organizationObj
        })
        
        // Reset loading state
        this.$store.commit('toggleReload')
        this.$store.commit('updateNewDataStatus', false) 
      })
    },
    showDeleteModal(row) {
      this.entityId = row.organization.id
      this.entityName = `"${row.full_name}"'`
      this.entityType = 'organization'
      this.$store.commit('updateDeleteModalState', true)
    },
    showInfoModal(row){
      this.modalData = row
      this.$store.commit('updateOrganizationInfoModalState', true)
    },
    showCreateModal() {
      this.formMethod = 'create'
      this.$store.commit('updateOrganizationUpsertModalState', true)
    },
    showUpdateModal(row) {
      this.formMethod = 'update'
      this.organization = row
      this.$store.commit('updateOrganizationUpsertModalState', true)
    }
  },
  watch: {
    hasNewData(current, old) {
      if(current == true) {
        this.getOrganizations()
        this.$store.commit('updateNewDataStatus', false)
      }
    }
  },
  computed: {
    ...mapState({
      isLoading: state => state.isReloading,
      hasNewData: state => state.hasNewData
    })
  }
}
</script>

<style>
  tr {
    cursor: pointer;
  }
</style>