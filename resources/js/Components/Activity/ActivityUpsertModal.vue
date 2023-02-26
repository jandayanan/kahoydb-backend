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
import { upsertActivity } from '@/service/api'

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
        status: "pending",
        errors: []
      },
    }
  },
  watch: {
    isVisible(newState, oldState) {
      this.isModalVisible = newState
    },
    activity(newData, oldData) {
      if(this.method == 'update') {
        this.form.id = newData.id
        this.form.name = newData.name 
        this.form.startDate = newData.start_date 
        this.form.endDate = newData.end_date 
        this.form.status = newData.activity_status
      }
    }
  },  
  methods: {
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