<template>
  <h1 class="text-center">{{ activity.name }}</h1>
  <p class="text-center">
    <i>
      "The true meaning of life is to plant trees, under whose shade you do not expect to sit - Nelson Henderson"
    </i>
  </p>
  <CForm @submit.prevent="submit">
    <CFormLabel for="emailInput">Email address</CFormLabel>
    <CFormInput v-model="form.email" type="email" id="emailInput" placeholder="name@example.com" required/>
    <CFormText component="span" class="mb-3">
      Required
    </CFormText>

    <CFormLabel for="firstNameInput">Name</CFormLabel>
    <CFormInput v-model="form.fullName" type="text" id="fullNameInput" placeholder="John"  required/>
    <CFormText component="span" class="mb-3">
      Required
    </CFormText>

    <CFormLabel for="lastNameInput">Contact No.</CFormLabel>
    <CFormInput v-model="form.contactNo" type="text" id="contactNoInput" placeholder="09937899902" class="mb-3"/>

    <CFormLabel for="plantedAtInput">Area Planted</CFormLabel>
    <CFormInput v-model="form.plantedAt" type="text" id="plantedAtInput" placeholder="Marilog" required />
    <CFormText component="span" class="mb-3">
      Required
    </CFormText>

    <CFormLabel for="donatedAtInput">Donated At</CFormLabel>
    <CFormInput v-model="form.donatedAt" type="text" id="donatedAttInput" placeholder="Marilog" required />
    <CFormText component="span" class="mb-3">
      Required
    </CFormText>

    <CFormLabel for="treeSpeciesInput">Specie of Tree</CFormLabel>
    <select v-model="form.treeSpecies" aria-label="Default select example" class="form-select" required>
      <option value="">--Select Specie of Tree --</option>
      <option v-for="specie in treeSpecies" :key="specie.id" :value="specie.value">{{ specie.value }}</option>
    </select>
    <CFormText component="span" class="mb-3">
      Required
    </CFormText>
    
    <CFormLabel for="treeTypeInput">Type of Tree</CFormLabel>
    <select v-model="form.treeType" aria-label="Default select example" class="form-select" required>
      <option value="">--Select Type of Tree --</option>
      <option v-for="type in treeTypes" :key="type.id" :value="type.value">{{ type.value }}</option>
    </select>
    <CFormText component="span" class="mb-3">
      Required
    </CFormText>
    <div class="d-flex justify-content-center">
      <span class="text-danger text-center">{{ message }}</span>
    </div>
    <CButton color="success mt-3 w-100" type="submit" :disabled="submitDisabled">Submit</CButton>
</CForm>
</template>

<script>
import { getAllVariables, createTree, fetchActivity } from '@/service/api'

export default {
  props: {
    hash: {
      type: String
    },
    activityId: {
      type: String
    }
  },
  async created() {
    await this.fetchActivityDetails()
    await this.getVariables()
    this.getPlanterLocation()
  },
  data() {
    return {
      treeSpecies: [],
      treeTypes: [],
      activity: {},
      form: {
        activityId: this.activityId,
        hash: this.hash,
        fullName: null,
        email: null,
        contactNo: null,
        latitude: null,
        longitude: null,
        treeSpecies: "", 
        treeType: ""
      },
      message: null,
      submitDisabled: false
    }
  },
  methods: {
    async getVariables(){
      await getAllVariables('/of/tree.type')
      .then(res => {
        this.treeTypes = res.data.data.variables 
      })

      await getAllVariables('/of/tree.species')
      .then(res => {
        this.treeSpecies = res.data.data.variables
      })
    },
    async fetchActivityDetails() {
      await fetchActivity(this.activityId)
      .then(res => [
        this.activity = res.data.data.activities
      ])
    },
    getPlanterLocation() {
      if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((pos) => {
          this.form.latitude = pos.coords.latitude
          this.form.longitude = pos.coords.longitude
        });
      }
    },
    submit() {
      this.submitDisabled = true
      createTree(this.form)
      .then(res => {
        window.location.href = route('participate.view.tree', {
          tree_id: res.data.data.tree_id,
          hash: res.data.data.hash
        })
      })
      .catch(err => {
        this.message = err.response.data.message
        this.submitDisabled = false
      })
    }
  }
}
</script>

<style>

</style>