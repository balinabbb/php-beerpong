import { message } from 'antd';
import players from './_players';
import cups from './_cups';

export default {
    players,
    cups
}

const url = 'http://127.0.01:8000/api/v1/';//https://crossorigin.me/...
const defaultOptions = {
    headers: {
        'Accept': 'application/json',
        'Content-type': 'application/json',
    }
};

function request(params) {
    const { success, fail, endPoint, method, body, baseUrl, options, isMultipart } = params;
    const fetchParams = {
        ...defaultOptions,
        headers: isMultipart ? { 'Accept': 'application/json' } : defaultOptions.headers,
        method,
        body: isMultipart ? body : ((body && JSON.stringify(body)) || undefined),
        ...options
    };
    return fetch(`${baseUrl || url}${endPoint}`, fetchParams)
        .then(x => {
            if (x.status === 200)
                return { json: x.json() };
            if (x.ok)
                return { result: x };
            return { errorMessage: x.text() };
        }, fail)
        .then(({ json, result, errorMessage }) => {
            if (errorMessage)
                errorMessage.then(fail);
            else if (json)
                json.then(success);
            else if (result)
                success(result);
            else
                fail("Szerver oldali hiba");
        })
        .catch(fail);
}

function get(params) {
    return request({ ...params, method: 'GET' });
}

function post(params) {
    return request({ ...params, method: 'POST' });
}

function put(params) {
    return request({ ...params, method: 'PUT' });
}

function del(params) {
    return request({ ...params, method: 'DELETE' });
}
const api = {
    get, post, put, del
};

export function call(endPoint, method, params) {
    return (success, fail) =>
        api[method || 'get']({
            endPoint,
            success,
            fail: fail || (err => err instanceof TypeError ? true : message.error(err)),
            ...params
        });
}