import { User } from '@/Shared/DataTable/Types/User'
import { Article } from '@/Shared/DataTable/Types/Article'

export interface DataTableActionsItem {
    id: string | number
    type?: 'Users' | string | null
    metaData?: User | Article | boolean
}
