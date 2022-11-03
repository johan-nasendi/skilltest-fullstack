import axios from 'axios';
import authHeader from './auth-header';

const API_URL = 'https://testskill-fullstack.herokuapp.com/api/';

class UserService {
    getPublicContent() {
        return axios.get(API_URL + '/');
    }

    getUserBoard() {
        return axios.get(API_URL + 'user', { headers: authHeader() });
    }


    getAdminBoard() {
        return axios.get(API_URL + 'todo', { headers: authHeader() });
    }
}

export default new UserService();
