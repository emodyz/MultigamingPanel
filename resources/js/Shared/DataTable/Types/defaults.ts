import { DataTableActionsOptions } from '@/Shared/DataTable/Types/DataTableActionsOptions.d.ts'

// eslint-disable-next-line import/prefer-default-export
export const defaultActionsOptions: DataTableActionsOptions = {
  enabled: false,
  baseUrl: '',
  show: {
    enabled: false,
    displayName: 'See',
    permission: '',
    path: '',
    icon: '',
    color: 'white',
    hvColor: 'green-500',
  },
  edit: {
    enabled: false,
    displayName: 'Edit',
    permission: '',
    path: 'edit',
    icon: '',
    color: 'white',
    hvColor: 'blue-500',
  },
  destroy: {
    enabled: false,
    displayName: 'Delete',
    permission: '',
    path: '',
    icon: '',
    color: 'white',
    hvColor: 'red-500',
  },
}
