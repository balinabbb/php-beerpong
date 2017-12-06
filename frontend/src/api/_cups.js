import {call} from './';

const baseUrl = 'cups';

export default {
    all: () => call(`${baseUrl}`),
    save: (date) => call(`${baseUrl}`, 'post', {body: {date}}),
    delete: (id) => call(`${baseUrl}/${id}`, 'del'),
}