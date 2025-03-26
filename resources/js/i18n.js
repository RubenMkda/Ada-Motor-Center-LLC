import { createI18n } from 'vue-i18n';

const messages = {
    en: {
        welcome: 'Welcome',
        vehicles: 'Vehicles',
        broker: 'Broker',
        about_us: 'About Us',
        blog: 'Blog',
        account: 'Account',
        dashboard: 'Dashboard',
        login: 'Log in',
        register: 'Register',
    },
    es: {
        welcome: 'Bienvenido',
        vehicles: 'Vehículos',
        broker: 'Corredor',
        about_us: 'Nosotros',
        blog: 'Blog',
        account: 'Cuenta',
        dashboard: 'Tablero',
        login: 'Iniciar sesión',
        register: 'Registrarse',
    },
};

const i18n = createI18n({
    legacy: false, 
    locale: 'es', 
    fallbackLocale: 'en', 
    messages,
});

export default i18n;
