import { createInertiaApp } from '@inertiajs/vue2'
import createServer from '@inertiajs/vue2/server'
import Vue from 'vue'

// FRONT DEPENDENCY
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
import Vue2ClickOutside from 'vue2-click-outside';
import VueHead from 'vue-head';
import App from './App.vue';

import router from './router';
import store from './store';
import i18n from './i18n';
// ### FRONT DEPENDENCY
import { createRenderer } from 'vue-server-renderer'

createServer(page =>
	createInertiaApp({
		page,
		render: createRenderer().renderToString,
		resolve: name => {
			const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
			return pages[`./Pages/${name}.vue`]
		},
		setup({ App, props, plugin }) {
			// Vue.use(plugin)
			Vue.use(BootstrapVue);
			Vue.use(BootstrapVueIcons);
			Vue.use(Vue2ClickOutside);
			Vue.use(VueHead, {
				separator: ' ',
			});
			return new Vue({
				router,
				store,
				i18n,
				render: h => h(App, props),
			})
		},
	}),
)
