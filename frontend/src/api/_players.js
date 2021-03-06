import {call} from './';

const baseUrl = 'players';

export default {
    all: () => call(`${baseUrl}`),
    save: (name) => call(`${baseUrl}`, 'post', {body: {name}}),
    delete: (id) => call(`${baseUrl}/${id}`, 'del'),
}