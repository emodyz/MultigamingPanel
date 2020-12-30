import { DataTableActionsOptions } from '@/Shared/DataTable/Types/DataTableActionsOptions'

// eslint-disable-next-line import/prefer-default-export
export const defaultActionsOptions: DataTableActionsOptions = {
  enabled: false,
  baseUrl: '',
  actions: [
    {
      enabled: false,
      displayName: 'See',
      permission: '',
      path: '',
      type: 'show',
      class: 'text-green-600 hover:text-green-900',
    },
    {
      enabled: false,
      displayName: 'Edit',
      permission: '',
      path: 'edit',
      type: 'edit',
      class: 'text-indigo-600 hover:text-indigo-900',
    },
    {
      enabled: false,
      displayName: 'Delete',
      permission: '',
      path: '',
      type: 'destroy',
      class: 'text-red-600 hover:text-red-900',
    },
  ],
}
