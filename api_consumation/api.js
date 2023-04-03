import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api', // Replace with your API base URL
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json'
  }
})

export default api