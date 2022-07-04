import { AxiosStatic } from 'axios'
import Echo from 'laravel-echo'
import { Router } from '@inertiajs/inertia/types/router'
import { InertiaFormTrait } from '@inertiajs/inertia-vue'

declare module 'vue/types/vue' {
    interface Vue {
        $axios: AxiosStatic;
        $echo: Echo;
        $inertia: Router & InertiaFormTrait;
    }
}
