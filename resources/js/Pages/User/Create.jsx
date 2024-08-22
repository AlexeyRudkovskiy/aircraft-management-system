import Form from "./Form.jsx";
import {useCallback} from "react";
import {useNavigate} from "react-router-dom";
import Typography from "@mui/material/Typography";

export default () => {
    const navigate = useNavigate();

    const afterUpdate = useCallback(data => {
        navigate('/user')
    });

    return <div className={"w-1/3 min-w-96 shadow-md rounded-xl bg-white px-6 py-6"}>
        <Typography variant={'h6'}>Add new User</Typography>
        <Form url={'/api/user'} afterUpdate={afterUpdate} />
    </div>
}
