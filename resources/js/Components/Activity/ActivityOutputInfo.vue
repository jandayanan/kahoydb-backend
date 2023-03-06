<script setup>
  const props = defineProps({
    activity: {
      type: Object
    },
    trees: {
      type: Array,
      default: []
    },
    participants: {
      type: Array,
      default: []
    }
  })
  
  function copyTreeCreationLink(){
    var copyText = document.getElementById('linkInput')
    copyText.select()
    copyText.setSelectionRange(0, 99999)

    navigator.clipboard.writeText(copyText.value)
  }
</script>

<template>
  <CRow>
    <CCol sm="auto"><strong>Name:</strong></CCol>
    <CCol sm="auto">{{ activity.name }}</CCol>
  </CRow>
  <CRow class="mt-2">
    <CCol sm="auto"><strong>Start Date:</strong></CCol>
    <CCol sm="auto">{{ activity.start_date }}</CCol>
  </CRow>
  <CRow class="mt-2">
    <CCol sm="auto"><strong>End Date:</strong></CCol>
    <CCol sm="auto">{{ activity.end_date }}</CCol>
  </CRow>
  <CRow class="mt-2">
    <CCol sm="auto"><strong>Status:</strong></CCol>
    <CCol sm="auto">{{ activity.activity_status.toUpperCase() }}</CCol>
  </CRow>
  <CRow class="mt-2">
    <CCol sm="auto">
      <CFormInput 
          :value="`${route('participate.form', {activity_id: activity.id, hash: activity.app_hash})}`" 
          type="text" 
          id="linkInput"
          disabled 
          hidden/>
      <CPopover content="Copied" placement="bottom">
        <template #toggler="{ on }">
          <CButton color="primary" v-on="on" @click="copyTreeCreationLink">Generate Participation Link</CButton>
        </template>
      </CPopover>
    </CCol>
  </CRow>
  <CRow class="mt-4">
    <CCol sm="auto"><strong>No. of Participants:</strong></CCol>
    <CCol sm="auto">{{ participants.length }}</CCol>
  </CRow>
  <CRow>
    <CCol sm="auto"><strong>No. of Trees:</strong></CCol>
    <CCol sm="auto">{{ trees.length }}</CCol>
  </CRow>
</template>