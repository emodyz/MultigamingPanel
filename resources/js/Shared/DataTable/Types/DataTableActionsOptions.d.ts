export interface DataTableActionsOptions {
    enabled: boolean,
    baseUrl?: string,
    show: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
    },
    edit: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
    },
    destroy: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
    }
}
