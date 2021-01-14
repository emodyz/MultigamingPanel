import { User } from '@/Shared/DataTable/Types/User'

export interface Article {
    id: string | number
    title: string,
    subTitle?: string,
    slug: string,
    cover_image_url: string,
    cover_image_path: string,
    content: string,
    status: 'draft' | 'published'
    user_id: string | number
    author?: User
    servers?: any
    created_at: string
    published_at?: string
    updated_at: string
    deleted_at?: string
}
