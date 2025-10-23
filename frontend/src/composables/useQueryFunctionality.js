import { useRoute, useRouter } from "vue-router";

export const useQueryFunctionality = () => {
  const router = useRouter();
  const route = useRoute();
  const writeQuery = function (queryName, queryValue)
  {
    router.replace({
      query: {
        ...route.query,
        [queryName]: queryValue,
      }
    })
  }

  return {
    writeQuery,
  }
}
