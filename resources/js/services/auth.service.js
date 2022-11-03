import axios from 'axios';

const API_URL = 'https://testskill-fullstack.herokuapp.com/api/';

class AuthService {
    login(user) {
        return axios
            .post(API_URL + 'login', {
                email: user.email,
                password: user.password
            })
            .then(response => {
                if (response) {
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    localStorage.setItem('token', response.data.token)
                }

                return response.data;
            });
    }

    logout() {
        localStorage.removeItem('user');
    }

    register(user) {
        return axios.post(API_URL + 'register', {
            name: user.name,
            email: user.email,
            password: user.password
        });
    }
}

export default new AuthService();
