import API from '../constants/api.js';
import { API_CONTACTS, API_IMPORT } from '../constants/conf.js'


const Contact = class ContactService {
    
    async import(data) {
        return await API().post(API_IMPORT, data);
    }

    async get() {
        return await API().get(API_CONTACTS);
    }

}

export default Contact.prototype;