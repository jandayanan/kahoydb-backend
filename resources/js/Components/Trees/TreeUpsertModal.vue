<template>
  <CModal size="md" backdrop="static" @close="closeModal" :visible="showModal">
    <CModalHeader>
      <CModalTitle>{{ method == 'create' ? 'Insert New Tree': 'Update Tree Info' }}</CModalTitle>
    </CModalHeader>
    <CForm @submit="submit">
      <CModalBody>
        <label for="planterInput" class="form-label">Planter</label>
        <v-select 
          id="treeSelect2Input"
          label="full_name" 
          v-model="planter"
          :options="participants" />
        <div class="form-text">Required</div>
        <CFormInput
          type="text"
          id="areaPlantedInput"
          label="Area Planted"
          required="true"
          placeholder="Marilog"
          text="Required"
          v-model="form.plantedAt"
        />
        <CFormInput
          type="text"
          id="donatedAtInput"
          label="Donated At"
          required="true"
          placeholder="Marilog"
          text="Required"
          v-model="form.donatedAt"
        />
        <CFormInput
          type="text"
          id="latitudeInput"
          label="Latitude"
          placeholder="1.25688547"
          v-model="form.latitude"
        />
        <CFormInput
          type="text"
          id="longitudeInput"
          label="Longitude"
          placeholder="-1.25688547"
          v-model="form.longitude"
        />
        <label for="treeSpecieInput" class="form-label">Specie</label>
        <CFormSelect
          class="mt-2"
          aria-label="Tree Species Selection"
          v-model="form.treeSpecies"
          :options="treeSpecies"
          required>
        </CFormSelect>
        <div class="form-text">Required</div>
        <label for="treeTypeInput" class="form-label">Tree Type</label>
        <CFormSelect
          class="mt-2"
          aria-label="Tree Type Selection Field"
          v-model="form.treeType"
          :options="treeTypes"
          required>
        </CFormSelect>
        <div class="form-text">Required</div>
        <label for="treeTypeInput" class="form-label">Tree Status</label>
        <CFormSelect
          class="mt-2"
          aria-label="Tree Status Selection Field"
          v-model="form.treeStatus"
          :options="treeStatuses"
          required>
        </CFormSelect>
        <div class="form-text">Required</div>
      </CModalBody>
      <CModalFooter>
        <CButton color="secondary" @click="closeModal">Close</CButton>
        <CButton color="success" type="submit">Submit</CButton>
      </CModalFooter>
      
    </CForm>
  </CModal>
</template>

<script>
import { mapState } from 'vuex'
import { upsertTree, getVariables } from '@/service/api'

export default {
  name: 'TreeUpsertModal',
  props: {
    method: {
      type: String,
      default: 'create'
    },
    activity: {
      type: Object
    },
    tree: {
      type: Object,
      default: {}
    },
    participants: {
      type: Array,
      default: []
    }
  },
  data(){
    return {
      isModalVisible: false,
      form: {
        id: null,
        activityId: null,
        planterId: null,
        plantedAt: null,
        donatedAt: null,
        latitude: null,
        longitude: null,
        treeType: "",
        treeSpecies: "",
        treeStatus: "",
        errors: []
      },
      planter: {},
      participantsSelect: [],
      treeTypes: [{label: '--Choose Tree Type--', value: "", disabled: true}],
      treeSpecies: [{label: '--Choose Tree Specie--', value: "", disabled: true}],
      treeStatuses: [{label: '--Choose Tree Status--', value: "", disabled: true}]
    }
  },
  watch: {
    planter(data){
      if(data) {
        if (data.origin) {
          this.form.planterId = data.id
        } else if(data.planter) {
          this.form.planterId = data.planter.id
        }
      }
    },
    tree(data) {
      if(this.method == 'update') {
        this.form.id = data.id
        this.form.activityId = data.activity_id
        this.form.planterId = data.planter.id 
        this.form.plantedAt = data.planted_at
        this.form.donatedAt = data.donated_at
        this.form.latitude = data.latitude
        this.form.longitude = data.longitude
        this.form.treeType = data.tree_type
        this.form.treeSpecies = data.tree_species
        this.form.treeStatus = data.tree_status
      }
    }
  },  
  updated() {
    this.form.activityId = this.activity.id
    let treeSelect2Input = document.getElementById('treeSelect2Input')
    if(treeSelect2Input && this.tree.planter) {
      treeSelect2Input.getElementsByClassName('vs__search')[0].value = this.tree.planter.full_name
    }
  },
  mounted() {
    this.getVariablesEntities()
  },
  methods: {
    closeModal() {
      this.clearFields()
      this.$store.commit('updateTreeUpsertModalState', false)
    },
    submit(event) {
      event.preventDefault()

      upsertTree(this.form)
      .then(() => {
        this.$store.commit('updateNewDataStatus', true)
        this.closeModal()
        this.$emit('inserted')
      })
    },
    clearFields(){
      this.form = {
        id: null,
        activityId: null,
        planterId: null,
        plantedAt: null,
        donatedAt: null,
        latitude: null,
        longitude: null,
        treeType: "",
        treeSpecies: "",
        treeStatus: "",
        errors: []
      }
    },
    async getVariablesEntities() {
      await getVariables('/of/tree.status')
      .then(res => {
        res.data.data.variables.forEach((variable)=> {
          this.treeStatuses.push({
            label: variable.value,
            value: variable.value
          })
        })
        if(this.treeStatuses.length > 1) {
          this.form.treeStatus = this.treeStatuses[1].value
        }
      })

      await getVariables('/of/tree.type')
      .then(res => {
        res.data.data.variables.forEach((variable)=> {
          this.treeTypes.push({
            label: variable.value,
            value: variable.value
          })
        })
        if(this.treeTypes.length > 1) {
          this.form.treeType = this.treeTypes[1].value
        }
      })

      await getVariables('/of/tree.species')
      .then(res => {
        res.data.data.variables.forEach((variable)=> {
          this.treeSpecies.push({
            label: variable.value,
            value: variable.value
          })
        })
        if(this.treeSpecies.length > 1) {
          this.form.treeSpecies = this.treeSpecies[1].value
        }
      })
    }
  },
  computed: {
    ...mapState({
      showModal: state => state.showTreeUpsertModal
    }) 
  }

}

</script>