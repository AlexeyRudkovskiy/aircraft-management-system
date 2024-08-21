import {createBrowserRouter, Outlet} from "react-router-dom";
import DashboardLayout from "./Layout/DashboardLayout.jsx";
import Dashboard from "./Pages/Dashboard.jsx";
import {
    Index as AircraftIndex,
    Add as AircraftAdd,
    Show as AircraftShow
} from './Pages/Aircraft'

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
                    },
                    {
                        path: 'create',
                        element: <AircraftAdd />
                    },
                    {
                        path: ':id',
                        element: <AircraftShow />
                    }
                ],
            }
        ]
    },
]);

export { router };
