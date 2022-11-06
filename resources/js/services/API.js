import axios from "axios";
import store from "../store";

export const apiClient = axios.create({
    baseURL: process.env.VUE_APP_API_URL + "https://testskill-fullstack.herokuapp.com/api",
    withCredentials: true,
});

apiClient.interceptors.response.use(
    (response) => {
        return response;
    },
    function(error) {
        if (
            error.response && [401, 419].includes(error.response.status) &&
            store.getters["/user"] &&
            !store.getters["/guest"]
        ) {
            store.dispatch("/logout");
        }
    }
)