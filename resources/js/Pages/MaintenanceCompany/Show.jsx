import {useCallback, useEffect, useState} from "react";
import {useNavigate, useParams} from "react-router-dom";
import Form from "./Form.jsx";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";

export default () => {
    const [company, setCompany] = useState({})
    const [loading, setLoading] = useState(true)
    const { id } = useParams()
    const navigate = useNavigate()

    useEffect(() => {
        async function loadCompany() {
            const response = await axios.get(`/api/maintenanceCompany/${id}`)
            setCompany(response.data.data)
            setLoading(false)
        }
        loadCompany()
    }, [ id ]);

    const deleteCompany = useCallback(async () => {
        if (!confirm('Are you sure you want to delete this maintenance company?')) {
            return ;
        }
        const response = await axios.delete(`/api/maintenanceCompany/${id}`)
        navigate('/maintenance-company');
    })

    if (loading) return <div>Loading...</div>

    return <div className={'flex'}>
        <div className={'w-full mr-6'}>
            <div className={'rounded-xl shadow-md bg-white p-6'}>
                <Typography variant={'h6'}>DANGER ZONE</Typography>
                <div className={'mt-4'}></div>
                <Button color={'error'} variant={'contained'} onClick={deleteCompany}>Delete Maintenance Company</Button>
            </div>
        </div>
        <div className={'rounded-xl shadow-md bg-white p-6 w-auto w-4/12 min-w-96 shrink-0 grow-0'}>
            <Form mode={'edit'} url={`/api/maintenanceCompany/${id}`} data={company} />
        </div>
    </div>;
}
