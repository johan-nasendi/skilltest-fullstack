import axios from "axios";
import store from "../store";

export const authClient = axios.create({
    baseURL: process.env.VUE_APP_API_URL,
    withCredentials: true, // required to handle the CSRF token
});

/*
 * Add a response interceptor
 */
authClient.interceptors.response.use(
    (response) => {
        return response;
    },
    function(error) {
        if (
            error.response && [401, 419].includes(error.response.status) &&
            store.getters["/user"] &&
            !store.getters["/guest"]
        ) {
            store.dispatch("logout");
        }
        return Promise.reject(error);
    }
);

export default {
    async login(payload) {
        await authClient.get("/sanctum/csrf-cookie");
        return authClient.post("/login", payload);
    },
    logout() {
        return authClient.get("/logout");
    },
    // async forgotPassword(payload) {
    //     await authClient.get("/sanctum/csrf-cookie");
    //     return authClient.post("/forgot-password", payload);
    // },
    getAuthUser() {
        return authClient.get("/api/user");
    },
    // async resetPassword(payload) {
    //     await authClient.get("/sanctum/csrf-cookie");
    //     return authClient.post("/reset-password", payload);
    // },
    updatePassword(payload) {
        return authClient.put("/profile/change-password", payload);
    },
    async registerUser(payload) {
        await authClient.get("/sanctum/csrf-cookie");
        return authClient.post("/register", payload);
    },
    // sendVerification(payload) {
    //     return authClient.post("/email/verification-notification", payload);
    // },
    updateUser(payload) {
        return authClient.put("/profile/update", payload);
    },
};