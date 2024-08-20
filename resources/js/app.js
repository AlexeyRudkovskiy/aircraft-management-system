import './bootstrap';
import axios from "axios";

await axios.get('/sanctum/csrf-cookie')

await axios.post('/login', {
    email: 'admin@example.com',
    password: 'password'
})

const response = await axios.get('/api/me')
console.log(response.data);
