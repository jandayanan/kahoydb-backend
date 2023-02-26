import axios from 'axios'

const token = localStorage.getItem('api_token')

axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
axios.defaults.baseURL = import.meta.env.VITE_API_URL

export function getAllActivities() {
  return new Promise((resolve, reject) => {
    axios.get('activities/all')
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

export function getAllEntities() {
  return new Promise((resolve, reject) => {
    axios.get('entities/all?relations[0]=participants.activity.trees')
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
