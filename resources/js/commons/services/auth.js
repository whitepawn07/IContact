// import API from '../commons/constants/api.js';
import API from '../constants/api.js';
import { AUTH_KEY, API_LOGIN, API_REGISTER } from '../constants/conf.js'

const Auth = class AuthService {
    
    async login(data) {
        return await API().post(API_LOGIN, data)
    }

    setToken(data) {
        (window).localStorage[AUTH_KEY] = data.access_token;
    }

    rmToken() {
        (window).localStorage.removeItem(AUTH_KEY)
    }

    authenticated() {
        return this.getToken() ? true : false;
    }

    getToken() {
        // fetch the generated token from the storage
        const d = (window).localStorage[AUTH_KEY];
        if (!d) {
            return null;
        }
        return d;
    }
}

export default Auth.prototype;