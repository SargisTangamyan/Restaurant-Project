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

  const init = function () {
    // Load initial value from URL
    query.value = route.query[queryParam] || ''
  }

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
    emitWordChosen?.(item.id)
    updateQuery()
  }

  function clearQuery() {
    router.replace({
      query: { ...route.query, [queryParam]: undefined }
    })
    query.value = ''
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
