<template>
  <div>
    <ParticipantsTable :items="items" @selectedRow="showInfoModal"/>
    <ParticipantInfoModal :entity="modalData"/>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { getAllEntities} from '@/service/api'
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
      modalData: []
    }
  },
  mounted(){
    this.getEntities()
  },
  methods: {
    getEntities(){
      // Toggle loading state 
      this.$store.commit('toggleReload')

      getAllEntities('relations[0]=participants.activity.trees.activity&relations[1]=participants.entity')
      .then(res => {
        this.items = res.data.data.entity
        
        // Reset loading state
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