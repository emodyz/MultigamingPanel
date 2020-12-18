// eslint-disable-next-line import/prefer-default-export
export function objectToFormData(object: any, method: 'POST' | 'PUT' | 'PATCH' | 'DELETE' | null = null, formData = new FormData(), parent: any = null) {
  if (object === null || object === 'undefined' || object.length === 0) {
    return formData.append(parent, object)
  }

  // eslint-disable-next-line no-restricted-syntax
  for (const property in object) {
    // eslint-disable-next-line no-prototype-builtins
    if (object.hasOwnProperty(property)) {
      // eslint-disable-next-line no-use-before-define
      appendToFormData(formData, getKey(parent, property), object[property])
    }
  }

  if (method) {
    formData.append('_method', 'PUT')
  }
  return formData
}

function getKey(parent: any, property: any) {
  return parent ? `${parent}[${property}]` : property
}

// eslint-disable-next-line consistent-return
function appendToFormData(formData: any, key: any, value: any) {
  if (value instanceof Date) {
    return formData.append(key, value.toISOString())
  }

  if (value instanceof File) {
    return formData.append(key, value, value.name)
  }

  if (typeof value === 'boolean') {
    return formData.append(key, value ? '1' : '0')
  }

  if (value === null) {
    return formData.append(key, '')
  }

  if (typeof value !== 'object') {
    return formData.append(key, value)
  }

  objectToFormData(value, formData, key)
}
