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
  <CRow class="mt-4">
    <CCol sm="auto"><strong>No. of Participants:</strong></CCol>
    <CCol sm="auto">{{ participants.length }}</CCol>
  </CRow>
  <CRow>
    <CCol sm="auto"><strong>No. of Trees:</strong></CCol>
    <CCol sm="auto">{{ trees.length }}</CCol>
  </CRow>
</template>