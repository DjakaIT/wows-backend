import { createInertiaApp } from "@inertiajs/vue2";
import createServer from "@inertiajs/vue2/server";
import Vue from "vue";
import { createRenderer } from "vue-server-renderer";
createServer(
  (page) => createInertiaApp({
    page,
    render: createRenderer().renderToString,
    resolve: (name) => {
      const pages = /* @__PURE__ */ Object.assign({});
      return pages[`./Pages/${name}.vue`];
    },
    setup({ App, props, plugin }) {
      Vue.use(plugin);
      return new Vue({
        router,
        store,
        i18n,
        render: (h) => h(App, props)
      });
    }
  })
);
