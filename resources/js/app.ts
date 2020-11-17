import "./bootstrap"

import Vue from 'vue';
import { App, plugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';

import Moment from 'moment-timezone';
Moment.locale( document.documentElement.lang );
Moment.tz.setDefault( document.querySelector('meta[name="timezone"]').getAttribute('content') );

import lodash from "lodash";
import VueLodash from "vue-lodash";

Vue.use(VueLodash, { name: 'custom' , lodash: lodash })

// @ts-ignore
import { InertiaProgress } from "@inertiajs/progress";

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,

    // The color of the progress bar.
    color: '#6875f5',

    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: false,
})

// @ts-ignore
Vue.mixin({ methods: { route } });
Vue.mixin({ methods: { $moment: Moment } });
Vue.use(plugin);
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
