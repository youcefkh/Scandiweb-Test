import Vue from "vue";
import App from "./App.vue";
import axios from "axios";
import VueAxios from "vue-axios";
import router from "./router";

Vue.use(VueAxios, axios);

Vue.config.productionTip = false;

Vue.prototype.$hostname =
  "https://scandiweb-test-youcef.easy-soft-tlemcen.com";

new Vue({
  router,
  render: (h) => h(App),
}).$mount("#app");
