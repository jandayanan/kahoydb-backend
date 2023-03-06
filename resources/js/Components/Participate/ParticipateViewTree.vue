<template>
  <h1 class="text-center">View Tree Status</h1>
  <p class="text-center">
    <i>
      "A nation that destroys its soils destroys itself. Forests are the lungs of our land, purifying the air and giving fresh strength to our people." ― Franklin D. Roosevelt
    </i>
  </p>
  <CContainer class="py-6">
    <CRow>
      <CCol lg="9" md=7 sm=6>
        <CFormInput 
          :value="url" 
          type="text" 
          id="linkInput"
          disabled />
      </CCol>
      <CCol lg="3" md=5 sm=6>
        <CPopover content="Copied" placement="bottom">
          <template #toggler="{ on }">
            <CButton color="success" class="w-100" v-on="on" @click="copyLink">Copy link</CButton>
          </template>
        </CPopover>
      </CCol>
    </CRow>
  </CContainer>
  <CContainer>
    <CRow>
      <CCol sm="auto" class="text-sm-left text-center"><strong>Status:</strong></CCol>
      <CCol sm="auto" class="text-sm-left text-center">{{ tree.tree_status}}</CCol>
    </CRow>
    <CRow class="mt-3">
      <CCol sm="auto" class="text-sm-left text-center"><strong>Type of tree:</strong></CCol>
      <CCol sm="auto" class="text-sm-left text-center">{{ tree.tree_type }}</CCol>
    </CRow>
    <CRow class="mt-3">
      <CCol sm="auto" class="text-sm-left text-center"><strong>Species of tree:</strong></CCol>
      <CCol sm="auto" class="text-sm-left text-center">{{ tree.tree_species }}</CCol>
    </CRow>
    <CRow class="mt-3">
      <CCol sm="auto" class="text-sm-left text-center">
        <strong class="align-self-center">Location:</strong>
      </CCol>
      <CCol sm="auto" class="text-sm-left text-center">
        <CButton color="primary" @click="viewOnMap">
          View in Google Maps
        </CButton>
      </CCol>
    </CRow>
    <CRow class="mt-4"> 
      <CCol sm="auto" class="text-sm-left text-center"><strong>Area planted:</strong></CCol>
      <CCol sm="auto" class="text-sm-left text-center">{{ tree.planted_at }}</CCol>
    </CRow>
    <CRow class="mt-3">
      <CCol sm="auto" class="text-sm-left text-center"><strong>Donated At:</strong></CCol>
      <CCol sm="auto" class="text-sm-left text-center">{{ tree.donated_at }}</CCol>
    </CRow>
  </CContainer>
  <hr>
  <h1 class="text-center">Photos</h1>
  <hr>
  ...
</template>

<script>
import { getHashedTree } from '@/service/api'

export default {
  props: {
    treeId: {
      type: String
    },
    hash: {
      type: String
    }
  },
  data() {
    return {
      url: route('participate.view.tree', {
        tree_id: this.treeId,
        hash: this.hash
      }),
      tree: {}
    }
  },
  created() {
    this.getTree()
  },
  methods: {
    getTree() {
      getHashedTree(this.treeId, this.hash)
      .then(res => this.tree = res.data.data.trees)
    },
    copyLink(){
      var copyText = document.getElementById('linkInput')
      copyText.select()
      copyText.setSelectionRange(0, 99999)

      navigator.clipboard.writeText(copyText.value)
    },
    viewOnMap() {
      window.open(`https://maps.google.com/?q=${this.tree.latitude},${this.tree.longitude}`, '_blank')
    }
  }
}
</script>

<style>

</style>