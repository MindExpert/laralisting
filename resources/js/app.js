import { createApp, h } from 'vue'
// import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue3';
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
import MainLayout from "./Layouts/MainLayout.vue";

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue')
        const page = await pages[`./Pages/${name}.vue`]();

        // Set a Default Layout, when not defined explicitly in the Page or 'undefined'
        page.default.layout = page.default.layout || MainLayout;

        return page;
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el);
    },
});