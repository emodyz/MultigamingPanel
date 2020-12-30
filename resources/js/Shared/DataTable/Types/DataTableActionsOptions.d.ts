export interface Action {
    enabled: boolean,
    displayName?: string,
    permission?: string,
    path?: string,
    type?: 'show' | 'edit' | 'destroy',
    class?: string,
}

export interface DataTableActionsOptions {
    enabled: boolean,
    baseUrl?: string,
    actions?: Array<Action>,
}
