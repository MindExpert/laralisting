import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue3' //'@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import { InertiaProgress } from '@inertiajs/progress'
import { ZiggyVue } from 'ziggy'
import '../css/app.css'

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue')
        const page = await pages[`./Pages/${name}.vue`]()

        // Set a Default Layout, when not defined explicitly in the Page or 'undefined'
        page.default.layout = page.default.layout || MainLayout

        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Head', Head)
            .component('Link', Link)
            .use(ZiggyVue)
            .mount(el)
    },
})

InertiaProgress.init({
    delay: 0,
    color: '#29d',
    includeCSS: true,
    showSpinner: true,
})