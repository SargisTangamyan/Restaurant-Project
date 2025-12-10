// composables/useSearch.js
import { ref } from 'vue'
import debounce from 'lodash/debounce'
import { useRouter, useRoute } from 'vue-router'

export function useSearchStrict({ searchFn, queryParam = 'q', jsonName, emitWordChosen, emitIncorrectWord, debounceTime = 300 }) {
  const query = ref('')
  const filteredItems = ref([])
  const message = ref('')

  const router = useRouter()
  const route = useRoute()

  // -------------------------------------------------------------
  // REVISED INIT FUNCTION
  // -------------------------------------------------------------
  const init = async function () {
    // 1. Load initial value from URL
    const initialQuery = route.query[queryParam] || ''
    query.value = initialQuery

    // 2. If a query exists in the URL, perform a search immediately
    if (initialQuery) {
      // NOTE: We call the filtering logic directly, not the debounced version
      const res = await searchFn(initialQuery)

      if (res.success) {
        // Find the exact match in the returned results
        const exactMatch = (res[jsonName] ?? []).find(item =>
          item.name.toLowerCase() === initialQuery.toLowerCase()
        )

        if (!exactMatch) {
          // Optionally, treat a non-exact but present query as an error
          emitIncorrectWord?.()
        }
      } else {
        // Handle search failure on init
        emitIncorrectWord?.()
      }
    }
  }
  // -------------------------------------------------------------

  const updateQuery = () => {
    router.replace({
      query: { ...route.query, [queryParam]: query.value || undefined }
    })
  }

  const filterItems = debounce(async () => {
    if (!query.value) {
      filteredItems.value = []
      message.value = ''
      return
    }

    const res = await searchFn(query.value)

    if (res.success) {
      filteredItems.value = res[jsonName] ?? []
      message.value = ''
    } else {
      filteredItems.value = []
      message.value = res.message || 'No results found'
      emitIncorrectWord?.()
    }
  }, debounceTime)

  function onInput() {
    updateQuery()
    filterItems()
  }

  function selectItem(item) {
    query.value = item.name
    filteredItems.value = []
    console.log(item.unit)
    emitWordChosen?.(item.id, item.name, item.unit)
    updateQuery()
  }

  function clearQuery() {
    router.replace({
      query: { ...route.query, [queryParam]: undefined }
    })
    query.value = ''
    emitWordChosen?.(null, null) // Optional: emit null/null when cleared
  }

  return {
    query,
    filteredItems,
    message,
    onInput,
    selectItem,
    clearQuery,
    init,
  }
}
