<template>
  <CModal size="md" @close="closeModal" :visible="isModalVisible">
    <CModalHeader>
      <CModalTitle>{{ method == 'create' ? 'Insert New Entity': 'Update Entity' }}</CModalTitle>
    </CModalHeader>
    <CForm @submit="submit">
      <CModalBody>
          <CFormInput
            type="text"
            id="firstNameInput"
            label="First Name"
            required="true"
            placeholder="John"
            text="Required"
            v-model="form.firstName"
          />
          <CFormInput
            type="text"
            id="lastNameInput"
            label="Last Name"
            required="true"
            placeholder="Doe"
            text="Required"
            v-model="form.lastName"
          />
          <CFormInput
            type="emaiol"
            id="emailInput"
            label="Email"
            required="true"
            placeholder="abc@gmail.com"
            text="Required"
            v-model="form.email"
          />
          <CFormInput
            type="number"
            id="contatNoInput"
            label="Contact #"
            required="true"
            placeholder=""
            text="Required"
            size="11"
            v-model="form.contactNo"
          />
          <CFormSelect
            class="mt-2"
            aria-label="Entity Status Selection Field"
            v-model="form.status"
            :options="[
              { label: '-- Choose status --', value: '', disabled: true},
              { label: 'Active', value: 'active' },
              { label: 'Inactive', value: 'inactive' },
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
import { upsertEntity } from '@/service/api'

export default {
  name: 'EntityUpsertModal',
  props: {
    isVisible: {
      type: Boolean,
      default: false
    },
    method: {
      type: String,
      default: 'create'
    },
    entity: {
      type: Object
    }
  },
  data(){
    return {
      isModalVisible: false,
      form: {
        id: undefined,
        firstName: null,
        lastName: null,
        email: null,
        contactNo: null,
        status: "active",
        errors: []
      },
    }
  },
  watch: {
    isVisible(newState, oldState) {
      this.isModalVisible = newState
    },
    entity(newData, oldData) {
      if(this.method == 'update') {
        this.form.id = newData.id
        this.form.firstName = newData.first_name 
        this.form.lastName = newData.last_name 
        this.form.email = newData.email 
        this.form.contactNo = newData.contact_number 
        this.form.status = newData.status
      }
    }
  },  
  methods: {
    closeModal() {
      this.isModalVisible= false
      this.clearFields()
      this.$emit('close')
    },
    submit(event) {
      event.preventDefault()

      upsertEntity(this.form)
      .then(res => {
        this.closeModal()
        this.$store.commit('updateNewDataStatus', true)
      })
    },
    clearFields(){
      this.form = {
        id: undefined,
        firstName: null,
        lastName: null,
        email: null,
        contactNo: null,
        status: "active",
        errors: []
      }
    }
  }
}

</script>