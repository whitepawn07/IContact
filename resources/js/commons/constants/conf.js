import { urlsafe } from '../utils/http.js';

export const AUTH_KEY = 'NCqrSTxQCGMK2wDvRL1';

// Configure backend API url
export const API_URL = '/api/';


/* AUTH
*/
export const API_AUTH = urlsafe(API_URL, 'auth');
export const API_LOGIN = urlsafe(API_AUTH, 'login');
export const API_REGISTER =  urlsafe(API_AUTH, 'register');
export const API_LOGOUT = urlsafe(API_AUTH, 'logout');

/*
Import Contacts
*/
export const API_CONTACTS = urlsafe(API_URL, 'contacts');
export const API_IMPORT = urlsafe(API_CONTACTS, 'create');