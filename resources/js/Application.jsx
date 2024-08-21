import DashboardLayout from "./Layout/DashboardLayout.jsx";
import Button from '@mui/material/Button';
import {useCallback} from "react";

export default ({ children }) => {
    const sayHello = useCallback(() => {
        alert('test');
    })

    return <DashboardLayout>
        {children}
    </DashboardLayout>;
}
