import {AxiosStatic} from "axios";
import Echo from "laravel-echo";

declare module 'vue/types/vue' {
    interface Vue {
        $axios: AxiosStatic;
        $echo: Echo;
        $inertia: any;
    }
}
