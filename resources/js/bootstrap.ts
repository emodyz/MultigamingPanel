/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios'
import Echo from 'laravel-echo'
import Vue from 'vue'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

const token: HTMLMetaElement | null = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

axios.defaults.withCredentials = true

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// @ts-ignore
window.Pusher = require('pusher-js')

/*
// @ts-ignore
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'app-key',
  wsHost: window.location.hostname,
  wsPort: 6001,
  wssPort: 6001,
  disableStats: true,
}) */

// @ts-ignore
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  forceTLS: true,
})

// @ts-ignore
Vue.prototype.$echo = window.Echo
Vue.prototype.$axios = axios

// @ts-ignore
// eslint-disable-next-line no-extend-native,func-names
String.prototype.trunc = function (n) {
  // @ts-ignore
  return this.substr(0, n - 1) + (this.length > n ? '…' : '')
}
