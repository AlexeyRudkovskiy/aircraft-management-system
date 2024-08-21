import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import axios from "axios";
import Application from "./Application.jsx";
import './bootstrap';

(async function () {
    await axios.get('/sanctum/csrf-cookie')

    const root = document.getElementById('app');
    if (root !== null) {
        createRoot(root).render(<Application />)
    }
})();
