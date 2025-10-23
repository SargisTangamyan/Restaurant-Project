// composables/useCartFunctionality.js
import { useCartStore } from '@/stores/cart'

export const useCartFunctionality = () => {
  const cartStore = useCartStore()

  const addToCart = async (id) => {
    const response = await cartStore.addToCart(id)

    if (response.success) {
      // Optionally re-fetch the cart or show a success message
      await cartStore.fetchCart()
    } else {
      console.error('Failed to add item:', response.errors)
    }
  }

  const removeFromCart = async (id) => {
    const response = await cartStore.removeFromCart(id)

    if (!response.success) {
      console.error('Failed to remove item:', response.errors)
    }
  }

  return {
    addToCart,
    removeFromCart,
  }
}

