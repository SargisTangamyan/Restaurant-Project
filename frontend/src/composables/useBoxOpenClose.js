export const useBoxOpenClose = function (reactiveBox) {
  let closer;

  const openBox = function () {
    if (closer) {clearTimeout(closer)}
    reactiveBox.value = true;
  }

  const closeBox = function () {
    if (closer) { clearTimeout(closer) }
    closer = setTimeout(() => { reactiveBox.value = false }, 200);
  }

  const handleOutsideClick = function () {
    closeBox();
    document.removeEventListener('click', handleOutsideClick);
  }

  const toggleShowBox = function (event) {
    event.stopPropagation();
    reactiveBox.value = !reactiveBox.value

    if (reactiveBox.value) {
      document.removeEventListener('click', handleOutsideClick);
      document.addEventListener('click', handleOutsideClick);
    } else {
      document.removeEventListener('click', handleOutsideClick);
    }
  }

  return {openBox, closeBox, toggleShowBox};
}
