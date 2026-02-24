import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

// Attach the XSRF-TOKEN cookie value as X-XSRF-TOKEN header on every request.
// Needed for Sanctum SPA cookie auth — more reliable than relying on axios's
// built-in withXSRFToken default across all versions.
window.axios.interceptors.request.use((config) => {
    const match = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]+)/);
    if (match) {
        config.headers['X-XSRF-TOKEN'] = decodeURIComponent(match[1]);
    }
    return config;
});
