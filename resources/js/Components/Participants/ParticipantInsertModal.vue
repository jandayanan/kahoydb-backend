<template>
  <CModal backdrop="static" size="lg" :visible="showModal" @close="resetModalState" id="participantModal">
    <CModalHeader>
      <CModalTitle>Add Participant</CModalTitle>
    </CModalHeader>
    <CForm @submit="submit">
      <CModalBody>
        <CContainer>
          <CRow class="mb-4">
            <CCol sm="4" xs="12" class="mb-2" v-for="entity in toInsert" :key="entity.id">
              <ParticipantSelectedCard 
                :entity="entity"
                @removed="removeEntityFromForm" />
            </CCol>
          </CRow>
          <EntitiesTable 
            :items="entities"
            :permission="'read'"
            @selectedRow="pushSelectedEntity"/>
        </CContainer>
      </CModalBody>
      <CModalFooter>
        <CSpinner v-if="isSubmitDisabled" color="success"/>
        <CButton color="secondary" @click="resetModalState">Close</CButton>
        <CButton color="success" type="submit" :disabled="isSubmitDisabled">Submit</CButton>
      </CModalFooter>
    </CForm>
  </CModal>
</template>

<script>
import { mapState } from 'vuex'
import { getAllEntities } from '@/service/api' 
import { sortArray } from '@/utils'
import { upsertParticipant } from '@/service/api'
import EntitiesTable from '@/Components/Entities/EntitiesTable.vue'
import ParticipantSelectedCard from './ParticipantSelectedCard.vue'

export default {
  name: "ParticipantInsertModal",
  components: {
    EntitiesTable,
    ParticipantSelectedCard
},
  props: {
    participants: {
      type: Array,
      default: []
    },
    activityId: {
      type: Number
    }
  },
  data() {
    return {
      entities: [],
      toInsert: [],
      isSubmitDisabled: false
    };
  },
  watch: {
    participants() {
      this.getEntities()
    }
  },
  methods: {
    getEntities() {
      getAllEntities()
      .then(res => {
        // Filter entities results, return entities that dont participate in the activity
        this.entities = res.data.data.entity.filter((entity) => {
          return this.participants.every((participant) => {
            return participant.origin.entity_id !== entity.id
          })
        })
      })
    },
    resetModalState() {
      this.entities = []
      this.toInsert = []
      this.$store.commit('updateParticipantInsertModalState', false)
      this.$store.commit('updateActivityOutputModalState', false)
    },
    pushSelectedEntity(row) {
      // Pushes entity to the array for inserting participants, then removes entity from the pack
      this.toInsert.push(row)
      this.entities = this.entities.filter(entity => entity.id != row.id)
    },
    submit(event) {
      event.preventDefault()

      let forms = this.toInsert
      this.isSubmitDisabled = true
      forms.forEach(form => {
        upsertParticipant(form, this.activityId)
        .then(() => {
          this.toInsert = this.toInsert.filter(data => data.id != form.id)
        })
      })

      this.isSubmitDisabled = false
      this.resetModalState()
      this.$emit('inserted')
    },
    removeEntityFromForm(item) {
      // Does the opposite, removes entity from the array for inserting participants 
      // then goes back to its original pack, then sorts the array by id since we're pushing an item
      this.toInsert = this.toInsert.filter(data => data.id != item.id)
      this.entities.push(item)
      this.entities = sortArray(this.entities, 'id')
    }
  },
  computed: {
    ...mapState({
      showModal: state => state.showParticipantInsertModal
    })
  }
}
</script>

<style>

</style>