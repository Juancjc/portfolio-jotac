import { createApp, createSSRApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { initializeFlashToast } from '@/lib/flashToast';
import { route } from '@/lib/route';

// PrimeVue + tema custom
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import DialogService from 'primevue/dialogservice';
import Tooltip from 'primevue/tooltip';
import Ripple from 'primevue/ripple';
import StyleClass from 'primevue/styleclass';
import FocusTrap from 'primevue/focustrap';
import JuanTheme from '@/theme';

// Ícones PrimeVue
import 'primeicons/primeicons.css';

const appName = import.meta.env.VITE_APP_NAME || 'Juan Carlos Justiniano Coelho';

// SSR-safe: o mesmo bundle roda em Node (warm-up do Vite) e no browser.
const isSSR = typeof window === 'undefined';

createInertiaApp({
    title: (title) => (title ? `${title} — ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'Welcome':
                return null;
            case name.startsWith('public/'):
                return PublicLayout;
            case name.startsWith('admin/'):
                return AdminLayout;
            case name.startsWith('auth/'):
                return AuthLayout;
            case name.startsWith('settings/'):
                return [AppLayout, SettingsLayout];
            default:
                return AppLayout;
        }
    },
    progress: { color: '#ed1515' },

    setup({ App, props, plugin, el }) {
        // Em SSR usamos createSSRApp; no cliente, createApp.
        const factory = isSSR ? createSSRApp : createApp;
        const app = factory({ render: () => h(App, props) });

        app.use(plugin);
        app.use(PrimeVue, {
            ripple: true,
            theme: {
                preset: JuanTheme,
                options: {
                    darkModeSelector: '.dark',
                    cssLayer: { name: 'primevue', order: 'theme, base, primevue' },
                },
            },
            locale: {
                accept: 'Confirmar',
                reject: 'Cancelar',
                emptyMessage: 'Sem resultados',
                emptySearchMessage: 'Nenhum registro encontrado',
                choose: 'Escolher',
                upload: 'Enviar',
                cancel: 'Cancelar',
            },
        });

        app.use(ToastService);
        app.use(ConfirmationService);
        app.use(DialogService);

        app.directive('tooltip', Tooltip);
        app.directive('ripple', Ripple);
        app.directive('styleclass', StyleClass);
        app.directive('focustrap', FocusTrap);

        // Expõe helper route() nos templates Vue
        app.config.globalProperties.route = route;

        // SSR: devolver a instância para renderToString.
        // Client: montar no DOM.
        if (isSSR) {
            return app;
        }
        app.mount(el);
    },
});

// Estas APIs tocam window/document — só rodam no browser.
if (!isSSR) {
    initializeTheme();
    initializeFlashToast();
}
