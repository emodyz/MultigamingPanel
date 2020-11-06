import "./bootstrap"

import Vue from 'vue';

import { App, plugin } from '@inertiajs/inertia-vue';
// @ts-ignore
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';

// @ts-ignore
Vue.mixin({ methods: { route } });
// @ts-ignore
Vue.use(plugin);
Vue.use(InertiaForm);
Vue.use(PortalVue);

const app: any = document.getElementById('app');

new Vue({
    render: h =>
        h(App, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name: string) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
