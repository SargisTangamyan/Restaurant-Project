import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export const useQueryWriter = function ({
                                          queryParam = 'q',
                                          debounceTime = 300
                                        } = {}) {
  const route = useRoute()
  const router = useRouter()
  const query = ref(route.query[queryParam] || '')
  // let timeoutId = null

  // watch(query, (newValue) => {
  //   clearTimeout(timeoutId)
  //   timeoutId = setTimeout(() => {
  //     router.replace({
  //       query: {
  //         ...route.query,
  //         [queryParam]: newValue || undefined
  //       }
  //     })
  //   }, debounceTime)
  // })

  watch(
    () => route.query[queryParam],
    (newVal) => {
      if (newVal !== query.value) query.value = newVal || ''
    }
  )

  const writeQuery = (value) => {
    query.value = value
    router.replace({
      query: {
        ...route.query,
        [queryParam]: value || undefined
      }
    })
  }

  const clearQuery = () => {
    query.value = ''
    router.replace({
      query: {
        ...route.query,
        [queryParam]: undefined
      }
    })
  }

  const clearAllExceptCurrent = async () => {
    await router.replace({
      query: {
        [queryParam]: query.value,
      }
    })
  }

  const clearAllQueries = () => {
    router.replace({ query: {} })
  }

  return { query, writeQuery, clearQuery, clearAllQueries, clearAllExceptCurrent }
}
