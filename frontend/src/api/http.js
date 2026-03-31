import axios from 'axios'
import { getToken } from '../services/auth'

const http = axios.create({
  baseURL: '/api',
  headers: {
    Accept: 'application/json',
  },
})

http.interceptors.request.use((config) => {
  const token = getToken()

  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
})

export default http
