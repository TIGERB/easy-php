import Vue from 'vue'; // get vue
import Vuex from 'vuex'; // get vuex
import VueResource from 'vue-resource';// get $http

Vue.use(Vuex);
Vue.use(VueResource);

var state = {
  cardData: [],
  isloadingComplete: false,
  busy: false,
  isShow: false,
};

var getters = {

}

var mutations = {
  updateLoadingState(state, data){
    state.isloadingComplete = data;
  },
  updateBusyState(state, data){
    state.busy = data;
  },
  addData(state, data){
    state.cardData = state.cardData.concat(data);
  },
  refreshData(state, data){
    state.cardData = data;
  },
  isShowAlert(state, data){
    state.isShow = data;
  }
};

var actions = {
  getData(context, object){
    var progress  = object.progress;
    var isRefresh = object.refresh;
    progress.$Progress.start();
    context.commit('updateLoadingState', false);
    context.commit('updateBusyState', true);

    /**
     * use vue-resource
     */
    Vue.http.get('Demo/demo/get').then(response => {
      if (response.data.code !== 200) {
        return;
      }
      var json = response.data.result;
      context.commit('updateLoadingState', true);
      context.commit('updateBusyState', false);
      if (isRefresh === true) {
         context.commit('refreshData', json);
      }else {
         context.commit('addData', json);
      }
      progress.$Progress.finish();
    }, response => {
        context.commit('updateBusyState', false);
        progress.$Progress.fail();
    });

    /**
     * use fetch
     */
    // fetch('/api.json')
    // .then(function(response) {
    //   return response.json();
    // }).then(function(json) {
    //     console.log(this.state.cardData);
    //   context.commit('updateLoadingState', true);
    //   context.commit('updateBusyState', false);
    //   if (isRefresh === true) {
    //     context.commit('refreshData', json);
    //   }else {
    //     context.commit('addData', json);
    //   }
    //   progress.$Progress.finish();
    // }).catch(function(error) {
    //   context.commit('updateBusyState', false);
    //   progress.$Progress.fail();
    // });
}

};

var moduleCard = {
  state: state,
  getters: getters,
  mutations: mutations,
  actions: actions
};

var store = new Vuex.Store({
  state: state,
  getters: getters,
  mutations: mutations,
  actions: actions
});

module.exports = store;

// export default new Vuex.Store({
//   modules: {
//     moduleCard: moduleCard
//   }
// });
