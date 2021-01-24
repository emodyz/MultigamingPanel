export interface Action {
    enabled: boolean,
    displayName?: string,
    permission?: string,
    path?: string,
    type?: 'show' | 'edit' | 'destroy' | 'custom',
    class?: string,
}

export interface DataTableActionsOptions {
    enabled: boolean,
    baseUrl?: string,
    destroyDialog?: any,
    actions?: Array<Action>,
}
