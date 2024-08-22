import {useCallback, useEffect, useState} from "react";
import {useNavigate, useParams} from "react-router-dom";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import Form from "./Form.jsx";



export default () => {
    const [request, setRequest] = useState({})
    const [loading, setLoading] = useState(true)
    const { id } = useParams()
    const navigate = useNavigate()

    useEffect(() => {
        async function loadRequest() {
            const response = await axios.get(`/api/serviceRequest/${id}`)
            setRequest(response.data.data)
            setLoading(false)
        }
        loadRequest()
    }, [ id ]);

    const deleteRequest = useCallback(async () => {
        if (!confirm('Are you sure you want to delete this service request?')) {
            return ;
        }
        const response = await axios.delete(`/api/serviceRequest/${id}`)
        navigate('/service-request');
    })

    const setStatus = async (status) => {
        const response = await axios.post(`/api/serviceRequest/${id}/status`, { status })
        navigate(0)
    }

    const setPendingStatus = useCallback(() => setStatus('pending'));
    const setInProgressStatus = useCallback(() => setStatus('in_progress'));
    const setCompletedStatus = useCallback(() => setStatus('completed'));

    if (loading) return <div>Loading...</div>

    return <div className={'flex'}>
        <div className={'w-full mr-6'}>
            <div className={'rounded-xl shadow-md bg-white p-6'}>
                <Typography variant={'h6'}>Statuses History</Typography>
                <div className={'mt-4'}></div>
                <List sx={{ width: '100%', maxWidth: 360, bgcolor: 'background.paper' }}>
                {request.statuses.map(status => (<ListItem key={status.id}>
                        <ListItemText primary={status.label} secondary={`${status.created_at} by ${status.user.name} (${status.user.email})`} />
                    </ListItem>))}
                </List>
            </div>
            <div className={'rounded-xl shadow-md bg-white p-6 mt-6'}>
                <Typography variant={'h6'}>Manage Status</Typography>
                <div className={'mt-4'}></div>
                <div className="flex">
                    <div className={'mr-4'}><Button color={'primary'} variant={'contained'} onClick={setPendingStatus}>Pending</Button></div>
                    <div className={'mr-4'}><Button color={'warning'} variant={'contained'} onClick={setInProgressStatus}>In Progress</Button></div>
                    <div className={'mr-4'}><Button color={'success'} variant={'contained'} onClick={setCompletedStatus}>Completed</Button></div>
                </div>
            </div>
            <div className={'rounded-xl shadow-md bg-white p-6 mt-6'}>
                <Typography variant={'h6'}>DANGER ZONE</Typography>
                <div className={'mt-4'}></div>
                <Button color={'error'} variant={'contained'} onClick={deleteRequest}>Delete Service Request</Button>
            </div>
        </div>
        <div>
            <div className={'rounded-xl shadow-md bg-white p-6 w-auto w-4/12 min-w-96 shrink-0 grow-0'}>
                <Typography variant={'h6'}>Edit Service Request</Typography>
                <Form mode={'edit'} url={`/api/serviceRequest/${id}`} data={request} />
            </div>

        </div>
    </div>;
}
