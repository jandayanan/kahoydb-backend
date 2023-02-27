export function sortArray(array, key, order='desc') {
  if(order == 'desc') {
    return array.sort((a, b) => b[key] - a[key])
  } return array.sort((a, b) => a[key] - b[key])
}