import * as API from "../services/API";

export default {
    getUser(userId) {
        return API.apiClient.get(`/user/all/${userId}`);
    },
    getUsers(page) {
        return API.apiClient.get(`/user/all/?page=${page}`);
    },
    paginateUsers(link) {
        return API.apiClient.get(link);
    },
};