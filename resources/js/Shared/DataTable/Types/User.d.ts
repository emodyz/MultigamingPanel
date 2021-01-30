export interface User {
    authorizations?: Array<string>
    created_at: string
    email: string
    email_verified_at?: string | null
    id: string | number
    name: string
    profile_photo_path: string | null
    profile_photo_url: string | null
    role: string
    roleName?: string
}
