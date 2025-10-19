// src/stores/message.js
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useMessageStore = defineStore('message', () => {
  const message = ref('')
  const type = ref('success') // success | error | warning | info
  const visible = ref(false)

  const showMessage = (msg, msgType = 'success') => {
    message.value = msg
    type.value = msgType
    visible.value = true
  }

  const hideMessage = () => {
    visible.value = false
  }

  return { message, type, visible, showMessage, hideMessage }
})
