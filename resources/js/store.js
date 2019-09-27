import {getLocalUser} from "./helpers/auth";

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        projects: []
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.authError;
        },
        projects(state) {
            return state.projects;
        }
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null
        },
        loginSucess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = false;

        }
    },
    actions: {}
}
