/** @format */

import axios from 'axios'

const http = axios.create({
    baseURL: '/',
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    }
})

// Add a response interceptor
http.interceptors.response.use(
    response => response,
    error => {
        if (error.response) {
            if (error.response.status === 401 || error.response.status === 419) {
                alert('Session expired, re-authenticating...')
            } else if (error.response.status >= 500) {
                alert('Unexpected Error Occured. Something went wrong with the server.')
            }
        }

        return Promise.reject(error)
    }
)

export default http
