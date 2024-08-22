import {createBrowserRouter, Outlet} from "react-router-dom";
import DashboardLayout from "./Layout/DashboardLayout.jsx";
import Dashboard from "./Pages/Dashboard.jsx";
import {
    Index as AircraftIndex,
    Add as AircraftAdd,
    Show as AircraftShow
} from './Pages/Aircraft'
import {
    Index as MaintenanceCompanyIndex,
    Create as MaintenanceCompanyCreate,
    Show as MaintenanceCompanyShow
} from './Pages/MaintenanceCompany'
import {
    Index as ServiceRequestIndex,
    Create as ServiceRequestCreate,
    Show as ServiceRequestShow
} from './Pages/ServiceRequest'
import {
    Index as UserIndex,
    Create as UserCreate,
    Show as UserShow
} from './Pages/User'
import {
    Login
} from "./Pages/Auth/index.jsx";

const router = createBrowserRouter([
    {
        path: '/login',
        element: <Login />
    },
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
            },
            {
                path: 'maintenance-company',
                element: <div><Outlet /></div>,
                children: [
                    {
                        path: '',
                        element: <MaintenanceCompanyIndex />
                    },
                    {
                        path: 'create',
                        element: <MaintenanceCompanyCreate />
                    },
                    {
                        path: ':id',
                        element: <MaintenanceCompanyShow />
                    }
                ]
            },
            {
                path: 'service-request',
                element: <div><Outlet /></div>,
                children: [
                    {
                        path: '',
                        element: <ServiceRequestIndex />
                    },
                    {
                        path: 'create',
                        element: <ServiceRequestCreate />
                    },
                    {
                        path: ':id',
                        element: <ServiceRequestShow />
                    }
                ]
            },
            {
                path: 'user',
                element: <div><Outlet /></div>,
                children: [
                    {
                        path: '',
                        element: <UserIndex />
                    },
                    {
                        path: 'create',
                        element: <UserCreate />
                    },
                    {
                        path: ':id',
                        element: <UserShow />
                    }
                ]
            }
        ]
    }
]);

export { router };
