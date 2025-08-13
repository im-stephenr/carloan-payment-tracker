import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import ToastPlugin from "vue-toast-notification";
import "vue-toast-notification/dist/theme-bootstrap.css";
import "vue3-easy-data-table/dist/style.css";

createInertiaApp({
    progress: {
        delay: 250,
        color: "red",
        includeCSS: true,
        showSpinner: true,
    },
    title: (title) => `CLPT | ${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(ToastPlugin)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el);
    },
});

if ("serviceWorker" in navigator) {
    window.addEventListener("load", () => {
        navigator.serviceWorker
            .register("/serviceworker.js")
            .then((registration) => {
                console.log("ServiceWorker registered:", registration);
            })
            .catch((error) => {
                console.log("ServiceWorker registration failed:", error);
            });
    });
}
