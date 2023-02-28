<template>
  <CModal size="md" backdrop="static" @close="closeModal" :visible="showModal">
    <CModalHeader>
      <CModalTitle>{{ method == 'create' ? 'Insert New Tree': 'Update Tree Info' }}</CModalTitle>
    </CModalHeader>
    <CForm @submit="submit">
      <CModalBody>
        <label for="planterInput" class="form-label">Planter</label>
        <v-select 
          label="full_name"
          key="origin.id" 
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
        <CFormSelect
          class="mt-2"
          aria-label="Tree Species Selection"
          v-model="form.treeSpecies"
          :options="[
            { label: '-- Choose Specie --', value: ''},
            { label: 'Banana', value: 'banana' },
            { label: 'Cacao', value: 'cacao' },
            { label: 'Maple', value: 'maple' },
          ]"
          required>
        </CFormSelect>
        <CFormSelect
          class="mt-2"
          aria-label="Entity Status Selection Field"
          v-model="form.treeType"
          :options="[
            { label: '-- Choose Tree type --', value: ''},
            { label: 'Fruit Bearing', value: 'fruit_bearing' },
            { label: 'Non-Fruit Bearing', value: 'non_fruit_bearing' },
            { label: 'Hardwood', value: 'hardwood' },
          ]"
          required>
        </CFormSelect>
        <CFormSelect
          class="mt-2"
          aria-label="Entity Status Selection Field"
          v-model="form.treeStatus"
          :options="[
            { label: '-- Choose Tree status --', value: '', disabled: true},
            { label: 'Planted', value: 'planted' },
            { label: 'Seedling', value: 'seedling' },
            { label: 'Full Grown', value: 'full_grown' },
          ]"
          required>
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
import { mapState } from 'vuex'
import { upsertTree } from '@/service/api'

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
        treeType: null,
        treeSpecies: null,
        treeStatus: "planted",
        errors: []
      },
      planter: {},
      participantsSelect: []
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
  },
  methods: {
    closeModal() {
      this.clearFields()
      this.$store.commit('updateTreeUpsertModalState', false)
    },
    submit(event) {
      event.preventDefault()
      if(this.form.planterId) {

      }

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
        treeType: null,
        treeSpecies: null,
        treeStatus: "planted",
        errors: []
      }
    }
  },
  computed: {
    ...mapState({
      showModal: state => state.showTreeUpsertModal
    }) 
  }

}

</script>