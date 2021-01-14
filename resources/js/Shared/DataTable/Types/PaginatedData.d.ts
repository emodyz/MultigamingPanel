import { User } from '@/Shared/DataTable/Types/User'
import { Article } from '@/Shared/DataTable/Types/Article'

interface Link {
    url: string | null
    label: string
    active: boolean
}

export interface PaginatedDate {
    data: Array<User | Article | object>
    links: Array<Link>
}
