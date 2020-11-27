import { AUTH_KEY } from '../constants/conf.js'
import axios from 'axios';

const base_origin = window.location.origin;
const token = localStorage.getItem(AUTH_KEY);

export default () => {
    return axios.create({
        baseURL: base_origin,
        headers: {
            'Authorization' : 'Bearer ' + token
        }
    });
};