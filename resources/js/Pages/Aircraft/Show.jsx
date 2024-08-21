import {Link, useNavigate, useParams} from "react-router-dom";
import {useCallback, useEffect, useState} from "react";
import axios from "axios";
import Paper from "@mui/material/Paper";
import Form from "./Form.jsx";
import Typography from "@mui/material/Typography";
import TableContainer from "@mui/material/TableContainer";
import Table from "@mui/material/Table";
import TableHead from "@mui/material/TableHead";
import TableRow from "@mui/material/TableRow";
import TableCell from "@mui/material/TableCell";
import TableBody from "@mui/material/TableBody";
import Priority from "../../Components/Priority.jsx";
import Status from "../../Components/Status.jsx";
import Button from "@mui/material/Button";

export default () => {
    const [aircraft, setAircraft] = useState({})
    const [loading, setLoading] = useState(true)
    const { id } = useParams()
    const navigate = useNavigate()

    const deleteAircraft = useCallback(async () => {
        if (confirm('Are you sure you want to delete this plane??')) {
            await axios.delete(`/api/aircraft/${aircraft.id}`)
            navigate('/aircraft')
        }
    })

    useEffect(() => {
        async function loadAircraft() {
            const response = await axios.get(`/api/aircraft/${id}`);
            setAircraft(response.data.data);
            setLoading(false);
        }
        loadAircraft()
    }, [ id ]);

    if (loading) {
        return <div>Loading...</div>
    }

    return <div className={'flex'}>
        <div className={'w-full mr-6'}>
            <div className={'rounded-xl shadow-md bg-white p-6'}>
                <Typography variant={'h6'}>Service Requests</Typography>

                <TableContainer component={Paper} className="mt-6">
                    <Table sx={{ minWidth: 650 }} aria-label="simple table">
                        <TableHead>
                            <TableRow>
                                <TableCell>Description</TableCell>
                                <TableCell>Priority</TableCell>
                                <TableCell>Status</TableCell>
                                <TableCell>Maintenance Company</TableCell>
                                <TableCell align="right">Actions</TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {aircraft.service_requests.map((serviceRequest) => (
                                <TableRow
                                    key={serviceRequest.id}
                                    sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                                >
                                    <TableCell>{serviceRequest.description}</TableCell>
                                    <TableCell><Priority priority={serviceRequest.priority} /></TableCell>
                                    <TableCell><Status status={serviceRequest.status} /></TableCell>
                                    <TableCell>{serviceRequest.maintenance_company.name}</TableCell>
                                    <TableCell align="right">
                                        <Link to={`/service-request/${serviceRequest.id}`} className="hover:underline text-sky-600">Details</Link>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </TableContainer>
            </div>
            <div className="mt-6 p-6 rounded-xl shadow-md bg-white">
                <Typography variant={'h6'}>DANGER ZONE</Typography>
                <div className={'mt-4'}></div>
                <Button color={'error'} variant={'contained'} onClick={deleteAircraft}>Delete Aircraft</Button>
            </div>
        </div>
        <div className={'rounded-xl shadow-md bg-white p-6 w-full w-4/12 min-w-96 shrink-0 grow-0'}>
            <Typography variant={'h6'}>Edit Aircraft</Typography>
            {!loading && <Form mode={'edit'}
                               data={{
                                   model: aircraft.model,
                                   serial_number: aircraft.serial_number,
                                   registration: aircraft.registration,
                                   maintenance_company_id: aircraft.maintenance_company_id
                               }}
                               url={`/api/aircraft/${aircraft.id}`}></Form>}
        </div>
    </div>
}
