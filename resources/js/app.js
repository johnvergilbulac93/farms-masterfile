import "./bootstrap";
import "../css/app.css";
import "animate.css";
import "notyf/notyf.min.css";

import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { Notyf } from "notyf";
import BreezeAuthenticatedLayout from "./Layouts/Authenticated";
import Pagination from "./Components/Pagination";
import Card from "./Components/Card";
import Card2 from "./Components/Card2";

const notyf = new Notyf({
    dismissible: true,
    ripple: true,
    duration: 2000,
});
window.notyf = notyf;

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText ||
    "Farms Masterfile";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .component("Link", Link)
            .component("BreezeAuthenticatedLayout", BreezeAuthenticatedLayout)
            .component("Card", Card)
            .component("Card2", Card2)

            .component("Pagination", Pagination)
            .component("Head", Head)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
