import { User } from '@/Shared/DataTable/Types/User.d.ts'

interface Link {
    url: string | null
    label: string
    active: boolean
}

export interface PaginatedDate {
    data: Array<User | object>
    links: Array<Link>
}
