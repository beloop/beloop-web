import Vue from 'vue'
import VueI18n from 'vue-i18n'

const lang = 'en'
Vue.use(VueI18n)

Vue.locale(lang, () => {
  return fetch(`/static/translations/${lang}.json`, {
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  })
    .then((res) => res.json())
    .then((json) => Promise.resolve(json))
    .catch((error) => Promise.reject(error))
}, () => (Vue.config.lang = lang))
