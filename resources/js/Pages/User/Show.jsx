import {useCallback, useEffect, useState} from "react";
import {useNavigate, useParams} from "react-router-dom";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import Form from "./Form.jsx";

export default () => {
    const [user, setUser] = useState({})
    const [loading, setLoading] = useState(true)
    const { id } = useParams()
    const navigate = useNavigate()

    useEffect(() => {
        async function loadUser() {
            const response = await axios.get(`/api/user/${id}`)
            setUser(response.data.data)
            setLoading(false)
        }
        loadUser()
    }, [ id ]);

    const deleteRequest = useCallback(async () => {
        if (!confirm('Are you sure you want to delete this user?')) {
            return ;
        }
        await axios.delete(`/api/user/${id}`)
        navigate('/user')
    })

    const removePassword = useCallback(data => {
        setUser(data.data);
    })

    if (loading) return <div>Loading...</div>

    return <div className={'flex'}>
        <div className={'w-full mr-6'}>
            <div className={'rounded-xl shadow-md bg-white p-6 mt-6'}>
                <Typography variant={'h6'}>DANGER ZONE</Typography>
                <div className={'mt-4'}></div>
                <Button color={'error'} variant={'contained'} onClick={deleteRequest}>Delete Service Request</Button>
            </div>
        </div>
        <div>
            <div className={'rounded-xl shadow-md bg-white p-6 w-auto w-4/12 min-w-96 shrink-0 grow-0'}>
                <Typography variant={'h6'}>Edit User</Typography>
                <Form mode={'edit'} url={`/api/user/${id}`} data={user} afterUpdate={removePassword} />
            </div>

        </div>
    </div>;
}
