import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useMessageStore = defineStore('message', () => {
  // Toast message state
  const message = ref('')
  const type = ref('success') // success | error | warning | info
  const visible = ref(false)

  // Confirmation dialog state
  const confirmDialog = ref({
    show: false,
    title: '',
    message: '',
    confirmText: 'Confirm',
    cancelText: 'Cancel',
    type: 'warning', // warning | danger | info
    onConfirm: null,
    onCancel: null,
    loading: false
  })

  /**
   * Show toast message
   */
  const showMessage = (msg, msgType = 'success') => {
    message.value = msg
    type.value = msgType
    visible.value = true
  }

  /**
   * Hide toast message
   */
  const hideMessage = () => {
    visible.value = false
  }

  /**
   * Show confirmation dialog
   */
  const showConfirm = ({
                         title = 'Confirm Action',
                         message = 'Are you sure?',
                         confirmText = 'Confirm',
                         cancelText = 'Cancel',
                         type = 'warning',
                         onConfirm = null,
                         onCancel = null
                       }) => {
    return new Promise((resolve, reject) => {
      confirmDialog.value = {
        show: true,
        title,
        message,
        confirmText,
        cancelText,
        type,
        loading: false,
        onConfirm: async () => {
          try {
            confirmDialog.value.loading = true
            if (onConfirm) {
              await onConfirm()
            }
            confirmDialog.value.show = false
            confirmDialog.value.loading = false
            resolve(true)
          } catch (error) {
            confirmDialog.value.loading = false
            reject(error)
          }
        },
        onCancel: () => {
          confirmDialog.value.show = false
          if (onCancel) {
            onCancel()
          }
          resolve(false)
        }
      }
    })
  }

  /**
   * Hide confirmation dialog
   */
  const hideConfirm = () => {
    confirmDialog.value.show = false
    confirmDialog.value.loading = false
  }

  /**
   * Set loading state for confirmation dialog
   */
  const setConfirmLoading = (loading) => {
    confirmDialog.value.loading = loading
  }

  return {
    // Toast message
    message,
    type,
    visible,
    showMessage,
    hideMessage,

    // Confirmation dialog
    confirmDialog,
    showConfirm,
    hideConfirm,
    setConfirmLoading
  }
})
