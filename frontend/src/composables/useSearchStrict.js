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

        // 3. If an exact match is found, automatically choose it (emit)
        if (exactMatch) {
          // IMPORTANT: Emit the chosen word to immediately set the external state.
          // We don't need a timeout here as this runs once on initialization.
          emitWordChosen?.(exactMatch.id, exactMatch.name)
        } else {
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

    console.log(query.value)
    const res = await searchFn(query.value)
    console.log(res)

    if (res.success) {
      filteredItems.value = res[jsonName] ?? []
      message.value = ''

      const exactMatch = filteredItems.value.find(item =>
        item.name.toLowerCase() === query.value.toLowerCase()
      )

      if (exactMatch) {
        // Automatically select/emit the word if an exact match is found
        setTimeout(() => {
          emitWordChosen?.(exactMatch.id, exactMatch.name)
        }, 50);
      }
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
    emitWordChosen?.(item.id, item.name)
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
