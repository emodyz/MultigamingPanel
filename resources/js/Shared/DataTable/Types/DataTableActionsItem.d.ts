import { User } from '@/Shared/DataTable/Types/User.d.ts'

export interface DataTableActionsItem {
    id: string | number
    type?: 'Users' | string | null
    metaData?: User | boolean
}
