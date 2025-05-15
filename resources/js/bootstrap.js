import axios from 'axios';
import * as bootstrap from 'bootstrap';
import $ from 'jquery';

window.bootstrap = bootstrap;
window.axios = axios;
window.$ = $;
window.jQuery = $;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
