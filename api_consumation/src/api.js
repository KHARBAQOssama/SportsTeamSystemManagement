// import axios from 'axios'

// const api = axios.create({
//   baseURL: 'http://127.0.0.1:8000/api', 
//   headers: {
//     'Content-Type': 'multipart/form-data',
//     Accept: 'application/json'
//   }
// })

// const token = localStorage.getItem('token')

// if (token) {
//   api.defaults.headers.common['Authorization'] = `Bearer ${token}`
// }

// export default api


import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json'
  }
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;