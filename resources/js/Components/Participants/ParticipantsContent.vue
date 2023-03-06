<template>
  <div>
    <ParticipantsTable :items="items" :showInfo="true" @selectedRow="showInfoModal"/>
    <ParticipantInfoModal :entity="modalData"/>
    <DeleteModal 
      :entityId="entityId"
      :entityName="entityName"
      :entityType="entityType" />
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { getAllEntities, getAllParticipants } from '@/service/api'
import ParticipantInfoModal from './ParticipantInfoModal.vue'
import ParticipantsTable from './ParticipantsTable.vue'

export default {
  name: 'ParticipantsContent',
  components: {
    ParticipantInfoModal,
    ParticipantsTable
  },  
  data(){
    return {
      items: [], 
      filters: {
        name: {
          value: '',
          keys: ['full_name', 'email']
        }
      },
      modalData: [],
      entityId: null,
      entityName: null,
      entityType: null
    }
  },
  mounted(){
    this.getEntities()
  },
  methods: {
    getEntities(){
      // Toggle loading state 
      this.$store.commit('toggleReload')

      getAllParticipants('relations[0]=entity.trees.activity&relations[1]=entity.participants.activity')
      .then(res => {
        this.items = res.data.data.participants
        this.items = this.items.map(item => {
          return item = {
            trees: _.get(item.entity, 'trees', []),
            participants: _.get(item.entity, 'participants', []),
            ...item.entity
          }
        })

        this.$store.commit('toggleReload')
        this.$store.commit('updateNewDataStatus', false) 
      })
    },  
    showInfoModal(row){
      this.modalData = row
    }
  },
  computed: {
    ...mapState({
      isLoading: state => state.isReloading,
    })
  }
}
</script>

<style>
  tr {
    cursor: pointer;
  }
</style>