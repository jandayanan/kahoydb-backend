<template>
  <CModal size="md" @close="closeModal" :visible="showModal">
    <CModalHeader>
      <CModalTitle>{{ method == 'create' ? 'Insert Participant': 'Update Entity' }}</CModalTitle>
    </CModalHeader>
    <CForm @submit.prevent="submit">
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
          type="text"
          id="contatNoInput"
          label="Contact #"
          required="true"
          placeholder=""
          text="Required"
          v-model="form.contactNo"
        />
        <select v-if="method == 'update'" v-model="form.participantStatus" class="form-select" aria-label="Participant status" required>
          <option value="">--Select Status</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>

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
import { createParticipant, upsertParticipant, updateEntity } from '@/service/api'

export default {
  name: 'ParticipantUpsertModal',
  props: {
    method: {
      type: String,
      default: 'create'
    },
    participant: {
      type: Object
    },
    activityId: {
      type: Number,
    }
  },
  data(){
    return {
      form: {
        id: null,
        activityId: this.activityId,
        firstName: null,
        lastName: null,
        email: null,
        contactNo: null,
        status: 'active',
        errors: []
      },
      isSubmit: false, 
      errorMessage: ""
    }
  },
  watch: {
    participant(newData) {
      if(this.method == 'update') {
        this.form.entityId = newData.id
        this.form.id = newData.origin.id,
        this.form.activityId = newData.activity.id
        this.form.firstName = newData.first_name 
        this.form.lastName = newData.last_name 
        this.form.email = newData.email 
        this.form.contactNo = newData.contact_number
        this.form.participantStatus = newData.origin.participant_status
        this.form.entityStatus = newData.origin.entity.status
      }
    }
  },  
  methods: {
    closeModal() {
      this.clearFields()
      this.$store.commit('updateParticipantUpsertModalState', false)
    },
    resetParent() {
      this.closeModal()
      this.$store.commit('updateActivityOutputModalState', false)
      this.$emit('inserted')
    },
    submit() {

      if(this.method == 'create') {
        this.isSubmit = true
        createParticipant(this.form)
        .then(() => {
          this.$store.commit('updateNewDataStatus', true)
          this.isSubmit = false
          this.resetParent()
        })
        .catch(err => {
          this.isSubmit = false
          this.errorMessage = err.response.data.message
        })
      }

      else if(this.method == 'update') {
        this.isSubmit = true
        var participantId = this.form.id 

        this.form.id = this.form.entityId
        this.form.status = this.form.entityStatus

        updateEntity(this.form)
        .then(() => {
          this.form.id = participantId
          this.form.status = this.form.participantStatus

          upsertParticipant(this.form, this.form.activityId)
          .then(() => {
            this.$store.commit('updateNewDataStatus', true)
            this.isSubmit = false
            this.resetParent()
          })
        })
      }

    },
    clearFields(){
      this.form = {
        id: null,
        firstName: null,
        lastName: null,
        email: null,
        contactNo: null,
        errors: []
      }
    }
  },
  computed: {
    ...mapState({
      showModal: state => state.showParticipantUpsertModal
    }) 
  }

}

</script>