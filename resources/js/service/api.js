import axios from 'axios'

const token = localStorage.getItem('api_token')

axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
axios.defaults.baseURL = import.meta.env.VITE_API_URL

export function getAllActivities(relations = '') {
  return new Promise((resolve, reject) => {
    axios.get(`activities/all?${relations}`)
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
} 

export function upsertActivity(data) {
  return new Promise((resolve, reject) => {
    let url = `activities/define?name=${data.name}&start_date=${data.startDate}&end_date=${data.endDate}&activity_status=${data.status}`
    if(data.id) {
      url = `${url}&id=${data.id}`  
    }
    axios.post(url)
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
}

export function deleteActivity(id) {
  return new Promise((resolve, reject) => {
    axios.post(`activities/delete/${id}`)
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
}

export function getAllEntities(relations = '') {
  return new Promise((resolve, reject) => {
    axios.get(`entities/all?${relations}`)
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
}

export function upsertEntity(data) {
  return new Promise((resolve, reject) => {
    let url = `entities/create?first_name=${data.firstName}&last_name=${data.lastName}&email=${data.email}&contact_number=${data.contactNo}&status=${data.status}`

    if (data.id) {
      url = `${url}&id=${data.id}`  
    }

    axios.post(url)
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
}

export function deleteEntity(id) {
  return new Promise((resolve, reject) => {
    axios.post(`entities/delete/${id}`)
    .then(res => resolve(res)) 
    .catch(err => reject(err.response.data))
  })
}

export function getAllParticipants() {
  return new Promise((resolve, reject) => {
    axios.get('participants/all?relations[0]=entity&relations[1]=activity')
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
}

export function upsertParticipant(data, activityId) {
  return new Promise((resolve, reject) => {
    if(data.status == null) {
      data.status = 'active'
    }
    axios.post(`participants/define?entity_id=${data.id}&activity_id=${activityId}&participant_status=${data.status}`)
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
}

export function getAllTrees(args='') {
  return new Promise((resolve, reject) => {
    axios.get(`trees/all?sort=id&order=desc&${args}`)
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
}

export function upsertTree(data) {
  return new Promise((resolve, reject) => {
    let url = `trees/define?
    activity_id=${data.activityId}&
    planter_id=${data.planterId}&
    planted_at=${data.plantedAt}&
    donated_at=${data.donatedAt}&
    tree_type=${data.treeType}&
    tree_status=${data.treeStatus}&
    tree_species=${data.treeSpecies}`

    if (data.id) {
      url = `${url}&id=${data.id}`  
    } 
    if(data.latitude) {
      url = `${url}&latitude=${data.latitude}`
    }
    if(data.longitude) {
      url = `${url}&longitude=${data.longitude}`
    }
    
    axios.post(url)
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
}

export function deleteTree(id) {
  return new Promise((resolve, reject) => {
    axios.post(`trees/delete/${id}`)
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
}

export function getAllVariables(args = '/all') {
  return new Promise((resolve, reject) => {
    let url = `variables${args}` 

    axios.get(url)
    .then(res => resolve(res))
    .catch(err => reject(err.response.data))
  })
}
