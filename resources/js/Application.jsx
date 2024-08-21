import DashboardLayout from "./Layout/DashboardLayout.jsx";
import Button from '@mui/material/Button';
import {useCallback} from "react";

export default () => {
    const sayHello = useCallback(() => {
        alert('test');
    })

    return <DashboardLayout>
        <Button variant="contained" onClick={sayHello}>Hello world</Button>
    </DashboardLayout>;
}
