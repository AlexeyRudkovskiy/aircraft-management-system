import axios from "axios";
import {useEffect, useState} from "react";
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import Button from "@mui/material/Button";
import Typography from "@mui/material/Typography";
import {Link} from "react-router-dom";
import Status from "../../Components/Status.jsx";
import Priority from "../../Components/Priority.jsx";

export default () => {
    const [serviceRequests, setServiceRequests] = useState([]);

    useEffect(() => {
        async function loadServiceRequests() {
            const response = await axios.get('/api/serviceRequest');
            setServiceRequests(response.data.data);
        }
        loadServiceRequests();
    }, []);

    return <div>
        <div className={"flex align-items-center"}>
            <Typography variant={"h4"}>Service Requests</Typography>
            <div className={"inline-block ml-4 flex align-items-center"}>
                <Button to={"/service-request/create"} component={Link}>Add New</Button>
            </div>
        </div>

        <TableContainer component={Paper} className="mt-6">
            <Table sx={{ minWidth: 650 }}>
                <TableHead>
                    <TableRow>
                        <TableCell>Aircraft</TableCell>
                        <TableCell>Description</TableCell>
                        <TableCell align={'right'}>Status</TableCell>
                        <TableCell align={'right'}>Priority</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {serviceRequests.map((request) => (
                        <TableRow
                            key={request.id}
                            sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                        >
                            <TableCell>
                                {request.aircraft.model} ({request.aircraft.serial_number})
                            </TableCell>
                            <TableCell>
                                <Link to={`/service-request/${request.id}`} className={'hover:underline text-sky-600'}>{request.description}</Link>
                            </TableCell>
                            <TableCell align="right"><Status status={request.status} /></TableCell>
                            <TableCell align="right"><Priority priority={request.priority} /></TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </TableContainer>
    </div>
}
