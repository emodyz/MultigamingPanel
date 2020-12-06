export interface DataTableActionsOptions {
    enabled: boolean,
    baseUrl?: string,
    show: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
        icon?: string,
        color?: string,
        hvColor?: string,
    },
    edit: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
        icon?: string,
        color?: string,
        hvColor?: string,
    },
    destroy: {
        enabled: boolean,
        displayName?: string,
        permission?: string,
        path?: string,
        icon?: string,
        color?: string,
        hvColor?: string,
    }
}
