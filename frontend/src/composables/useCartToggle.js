import { computed } from 'vue'
import { useCartStore } from '@/stores/index.js'

export const useCartToggle = (dishId) => {
  const cartStore = useCartStore()

  const isInCart = computed(() => {
    return cartStore.getChosenIds.includes(+dishId.value || +dishId)
  })

  const isLoading = computed(() => cartStore.isLoading)

  const toggleCart = async () => {
    const id = dishId.value || dishId

    if (isInCart.value) {
      const response = await cartStore.removeFromCart(id)
      if (!response.success) {
        console.error('Failed to remove item:', response.errors)
      }
      return response
    } else {
      const response = await cartStore.addToCart(id)
      if (!response.success) {
        console.error('Failed to add item:', response.errors)
      }
      return response
    }
  }

  return {
    isInCart,
    isLoading,
    toggleCart,
  }
}
