<template>
  <CModal size="md" @close="resetModalState" :visible="showModal">
    <CModalHeader>
      <CModalTitle>{{ method == 'create' ? 'Insert Participant': 'Update Entity' }}</CModalTitle>
    </CModalHeader>
    <CForm @submit.prevent="submit">
      <CModalBody>
        <CFormInput
          type="text"
          id="fullNameInput"
          label="Organization Name"
          required="true"
          placeholder="John Doe"
          text="Required"
          v-model="form.fullName"
        />
        
        <CFormLabel for="parentOrganizationLabel">Parent Organization</CFormLabel>
        <v-select 
          id="parentOrgInput"
          label="fullName" 
          v-model="parentOrg"
          :options="parentOrganizations" />

        
        <CFormLabel for="organizationTypeLabel">Organization Type</CFormLabel>
        <select v-model="form.type" class="form-select" aria-label="Organization type" required>
          <option value="">--Select Type--</option>
          <option :value="type.key" v-for="type in orgTypes" :key="type.id"> {{ type.value }} </option>
        </select>
        <CFormText component="span">
          Required
        </CFormText>

        <div v-if="method == 'update'">
          <select v-model="form.status" class="form-select" aria-label="Organization status" required>
            <option value="">--Select Status--</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
          <CFormText component="span">
          Required
        </CFormText>
        </div>
        

        <span class="text-danger">{{ errorMessage }}</span>
      </CModalBody>
      <CModalFooter>
        <CButton color="secondary" @click="closeModal">Close</CButton>
        <CButton color="success" type="submit" :disabled="isSubmit">Submit</CButton>
      </CModalFooter>
      
    </CForm>
  </CModal>
</template>

<script>
import { mapState } from 'vuex'
import { getAllVariables, getAllOrganizations, createOrganization, upsertOrganization, updateEntity } from '@/service/api'

export default {
  name: 'OrganizationUpsertModal',
  props: {
    method: {
      type: String,
      default: 'create'
    },
    organization: {
      type: Object
    },
  },
  data(){
    return {
      form: {
        id: null,
        fullName: null,
        parentId: null,
        type: null,
        status: 'active',
        errors: []
      },
      parentOrg: null,
      orgTypes: [],
      parentOrganizations: [],
      isSubmit: false, 
      errorMessage: ""
    }
  },
  async created(){
    await this.getParentOrganizations()
    await this.getOrganizationTypes()
  },
  updated() {
    let organizationSelect2Input = document.getElementById('parentOrgInput')
    if(organizationSelect2Input && this.organization.organization) {
      let vsSelected = organizationSelect2Input.getElementsByClassName('vs__selected')
      if(vsSelected.length > 0) {
        vsSelected[0].remove()
      }
      
      organizationSelect2Input.getElementsByClassName('vs__search')[0].value = _.get(this.organization, 'organization.parent_organization_name', null)
    }
  },
  watch: {
    organization(newData) {
      if(this.method == 'update') {
        this.form.id = _.get(newData, 'organization.id', null),
        this.form.entityId = _.get(newData, 'id', null)
        this.form.fullName = _.get(newData, 'full_name', null)
        this.form.parentId = _.get(newData, 'organization.parent_organization_id', null)
        this.form.type = _.get(newData, 'organization.organization_type', null)
        this.form.status = _.get(newData, 'organization.organization_status', null)
      }
    },
    parentOrg(data) {
      console.log(data)
      this.form.parentId = _.get(data, 'id', null)
    }
  },  
  methods: {
    closeModal() {
      this.clearFields()
      this.$store.commit('updateOrganizationUpsertModalState', false)
    },
    async getOrganizationTypes() {
      await getAllVariables('/of/organization.type')
      .then(res => {
        this.orgTypes = res.data.data.variables
      })
    },
    async getParentOrganizations(){
      await getAllOrganizations()
      .then(res => {
        let items = res.data.data.organizations 
        this.parentOrganizations = items.filter(item => item.parent_organization_id == null) 
        this.parentOrganizations = this.parentOrganizations.map(org => {
          return {
            id: org.id,
            fullName: org.entity.full_name
          }
        })
      })
    },
    resetModalState(){
      let organizationSelect2Input = document.getElementById('parentOrgInput')
      let vsSelected = organizationSelect2Input.getElementsByClassName('vs__selected')
      
      if(vsSelected.length > 0) {
        vsSelected[0].remove()
      }

      organizationSelect2Input.getElementsByClassName('vs__search')[0].value = null

      this.closeModal()
      this.isSubmit = false
    },
    submit() {
      if(this.method == 'create') {
        this.isSubmit = true
        createOrganization(this.form)
        .then(res => {
          this.resetModalState()
          this.$store.commit('updateNewDataStatus', true)
        })
      }
      else if(this.method == 'update') {
        this.isSubmit = true
        upsertOrganization(this.form)
        .then(res => {
          let entityPayload = {
            id: this.form.entityId,
            fullName: this.form.fullName
          }
          updateEntity(entityPayload)
          .then(res => {
            this.resetModalState()
            this.$store.commit('updateNewDataStatus', true)
          })
        })

      }

    },
    clearFields(){
      this.form = {
        id: null,
        fullName: null,
        parentId: null,
        type: null,
        status: 'active',
        errors: []
      }
    }
  },
  computed: {
    ...mapState({
      showModal: state => state.showOrganizationUpsertModal
    }) 
  }

}

</script>