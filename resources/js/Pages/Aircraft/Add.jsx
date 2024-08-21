import Form from "./Form.jsx";
import Typography from "@mui/material/Typography";
import {useCallback} from "react";
import {useNavigate} from "react-router-dom";

export default () => {
    const navigate = useNavigate()
    const afterUpdate = useCallback(aircraft => {
        navigate(`/aircraft/${aircraft.id}`);
    })

    return <div className={"w-1/3 min-w-96 shadow-md rounded-xl bg-white px-6 py-6"}>
        <Typography variant={'h6'}>Add new Aircraft</Typography>
        <Form afterUpdate={afterUpdate} url={'/api/aircraft'}></Form>
    </div>
}
