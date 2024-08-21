import {createBrowserRouter, Outlet} from "react-router-dom";
import DashboardLayout from "./Layout/DashboardLayout.jsx";
import Dashboard from "./Pages/Dashboard.jsx";
import { Index as AircraftIndex } from './Pages/Aircraft'

const router = createBrowserRouter([
    {
        path: "/",
        element: <DashboardLayout />,
        children: [
            {
                path: '',
                element: <Dashboard />,
            },
            {
                path: "/aircraft",
                element: <div><Outlet /></div>,
                children: [
                    {
                        path: '',
                        element: <AircraftIndex />
                    }
                ],
            }
        ]
    },
]);

export { router };
