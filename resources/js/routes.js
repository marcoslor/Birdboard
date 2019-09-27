import Home from "./components/Home";
import Login from "./components/auth/Login";


export const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/login',
        component: Login
    }
];
