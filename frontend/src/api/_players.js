import {call} from './';

const baseUrl = 'players';

export default {
    all: () => call(`${baseUrl}`),
    save: (name, description) => call(`${baseUrl}`, 'post', {body: {name}}),
}