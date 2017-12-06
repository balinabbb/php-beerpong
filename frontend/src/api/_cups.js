import {call} from './';

const baseUrl = 'cups';

export default {
    all: () => call(`${baseUrl}`),
    getResults: (id) => call(`${baseUrl}/${id}`),
    save: (date) => call(`${baseUrl}`, 'post', {body: {date}}),
    addResult: (id, players, team1Result, team2Result) => call(`${baseUrl}/${id}`, 'put', {
        body: {
            players,
            team1Result,
            team2Result
        }
    }),
    delete: (id) => call(`${baseUrl}/${id}`, 'del'),
}