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

export function insertActivity(data) {
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