import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs';
import {createI18n} from "vue-i18n";
import en from './Locales/en.json';
import es from './Locales/es.json';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const i18n = createI18n({
    locale: 'es',
    fallbackLocale: 'es',
    legacy: false,
    messages: {
        en,
        es
    }
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .use(LaravelPermissionToVueJS)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
