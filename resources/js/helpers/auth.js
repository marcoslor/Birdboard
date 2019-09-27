export function login(credentials) {
    return new Promise((res, rej) => {
        axios.post('/login', credentials)
            .then((response) => {
                res(response.data)
            }).catch((error) => {
            rej(error.data.errors)
        })
    })
}

export function getLocalUser() {
    const userStr = localStorage.getItem("laravel_session");

    return !userStr ? null : JSON.parse(userStr);
}
