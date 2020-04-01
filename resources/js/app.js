
window.Vue = require('vue');

Vue.component(
    'passportClients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passportAuthorizedClients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passportPersonalAccessTokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

new Vue({
    el: '#passport'
});