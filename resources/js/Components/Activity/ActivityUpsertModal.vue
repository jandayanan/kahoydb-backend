<template>
  <CModal size="md" @close="closeModal" :visible="isModalVisible">
    <CModalHeader>
      <CModalTitle>{{ method == 'create' ? 'Insert New Activity': 'Update Activity' }}</CModalTitle>
    </CModalHeader>
    <CForm @submit="submit">
      <CModalBody>
          <CFormInput
            type="text"
            id="nameInput"
            label="Name"
            required="true"
            placeholder="John Doe"
            text="Required"
            v-model="form.name"
          />
          <label class="form-label mt-2" for="nameInput">Start Date</label>  
          <VDatePicker 
            v-model="form.startDate" 
            :format="dateFormat"
            required="true">
          </VDatePicker>
          <div class="form-text">Required</div>

          <label class="form-label mt-2" for="nameInput">End Date</label>  
          <VDatePicker 
            v-model="form.endDate"
            :format="dateFormat"
            required="true">
          </VDatePicker>
          <div class="form-text">Required</div>

          <CFormLabel for="parentOrganizationLabel" class="mt-3">Organizer</CFormLabel>
          <v-select 
            id="parentOrgInput"
            label="fullName" 
            v-model="org"
            :options="organizations">
            <template #search="{attributes, events}">
              <input
                class="vs__search"
                :required="!org"
                v-bind="attributes"
                v-on="events"
              />
            </template>
          </v-select>

          <CFormLabel for="activityStatusLabel" class="mt-3">Status</CFormLabel>
          <CFormSelect
            class="mt-2"
            aria-label="Activity Status Selection Field"
            v-model="form.status"
            :options="[
              { label: 'Pending', value: 'pending' },
              { label: 'In Progress', value: 'in_progress' },
              { label: 'For Follow Up', value: 'for_follow_up' },
              { label: 'Done', value: 'done' }
            ]">
          </CFormSelect>
      </CModalBody>
      <CModalFooter>
        <CButton color="secondary" @click="closeModal">Close</CButton>
        <CButton color="success" type="submit">Submit</CButton>
      </CModalFooter>
      
    </CForm>
  </CModal>
</template>

<script>
import { upsertActivity, getAllOrganizations } from '@/service/api'

export default {
  name: 'ActivityUpsertModal',
  props: {
    isVisible: {
      type: Boolean,
      default: false
    },
    method: {
      type: String,
      default: 'create'
    },
    activity: {
      type: Object
    }
  },
  data(){
    return {
      isModalVisible: false,
      form: {
        id: undefined,
        name: null,
        startDate: null,
        endDate: null,
        parentOrganizationId: null,
        childOrganizationId: null,
        status: "pending",
        errors: []
      },
      org: null,
      organizations: [],
    }
  },
  watch: {
    isVisible(newState, oldState) {
      this.isModalVisible = newState
    },
    activity(newData, oldData) {
      if(this.method == 'update') {
        console.log(newData)
        this.form.id = newData.id
        this.form.name = newData.name 
        this.form.startDate = newData.start_date 
        this.form.endDate = newData.end_date 
        this.form.parentOrganizationId = _.get(newData, 'parent_organization_id', null)
        this.form.childOrganizationId = _.get(newData, 'child_organization_id', null)
        this.form.status = newData.activity_status
        this.org = this.buildParentOrgSelected()
      }
    },
    org(data){
      if(data) {
        if(data.parentOrganizationId) {
          this.form.childOrganizationId = data.id 
          this.form.parentOrganizationId = null
        } else {
          this.form.parentOrganizationId = data.id
          this.form.childOrganizationId = null
        }
      }
    }
  },  
  created() {
    this.getOrganizationsOptions()
  },
  methods: {
    buildParentOrgSelected(){
      if(this.activity.parent_organization){
        return {
          id: _.get(this.activity.parent_organization, 'id', null),
          fullName: _.get(this.activity.parent_organization, 'entity.full_name', null),
          parentOrganizationId: _.get(this.activity.parent_organization, 'id', null)
        }
      }

      if(this.activity.child_organization){
        return {
          id: _.get(this.activity.child_organization, 'id', null),
          fullName: _.get(this.activity.child_organization, 'entity.full_name', null),
          parentOrganizationId: _.get(this.activity.child_organization, 'id', null)
        }
      }
      return null
    },
    closeModal() {
      this.isModalVisible= false
      this.clearFields()
      this.$emit('close')
    },
    dateFormat(date) {
      const day = date.getDate();
      const month = date.getMonth() + 1;
      const year = date.getFullYear();

      return `${year}-${month}-${day}`
    },  
    async getOrganizationsOptions() {
      await getAllOrganizations()
      .then(res => {
        this.organizations = res.data.data.organizations.map(org => {
          return {
            id: org.id,
            fullName: org.entity.full_name,
            parentOrganizationId: org.parent_organization_id
          }
        })
        
      })
    },
    submit(event) {
      event.preventDefault()
      let rawStartDate = new Date(this.form.startDate)
      let rawEndDate = new Date(this.form.endDate)
      
      this.form.startDate = `${rawStartDate.getFullYear()}-${rawStartDate.getMonth()+1}-${rawStartDate.getDate()}`
      this.form.endDate = `${rawEndDate.getFullYear()}-${rawEndDate.getMonth()+1}-${rawEndDate.getDate()}`

      upsertActivity(this.form)
      .then(res => {
        this.closeModal()
        this.$store.commit('updateNewDataStatus', true)
      })
    },
    clearFields(){
      this.form = {
        id: undefined,
        name: null,
        startDate: null,
        endDate: null,
        status: "active",
        errors: []
      }
    }
  }
}

</script>

<style>

</style>