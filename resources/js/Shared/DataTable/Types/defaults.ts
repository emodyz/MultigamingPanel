import { DataTableActionsOptions } from '@/Shared/DataTable/Types/DataTableActionsOptions'

// eslint-disable-next-line import/prefer-default-export
export const defaultActionsOptions: DataTableActionsOptions = {
  enabled: false,
  baseUrl: '',
  show: {
    enabled: false,
    displayName: 'See',
    permission: '',
    path: '',
  },
  edit: {
    enabled: false,
    displayName: 'Edit',
    permission: '',
    path: 'edit',
  },
  destroy: {
    enabled: false,
    displayName: 'Delete',
    permission: '',
    path: '',
  },
}
