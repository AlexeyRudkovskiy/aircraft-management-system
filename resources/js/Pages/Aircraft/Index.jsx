import axios from "axios";
import {useEffect, useState} from "react";
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import {Fab} from "@mui/material";
import {Add as AddIcon} from '@mui/icons-material'
import Button from "@mui/material/Button";
import Typography from "@mui/material/Typography";
import {Link} from "react-router-dom";

export default () => {
    const [aircrafts, setAircrafts] = useState([]);

    useEffect(() => {
        async function loadAircraft() {
            const response = await axios.get('/api/aircraft');
            setAircrafts(response.data.data);
        }
        loadAircraft();
    }, []);

    return <div>
        <div className={"flex align-items-center"}>
            <Typography variant={"h4"}>Aircraft</Typography>
            <div className={"inline-block ml-4 flex align-items-center"}>
                <Button to={"/aircraft/create"} component={Link}>Add New</Button>
            </div>
        </div>

        <TableContainer component={Paper} className="mt-6">
            <Table sx={{ minWidth: 650 }} aria-label="simple table">
                <TableHead>
                    <TableRow>
                        <TableCell>Model</TableCell>
                        <TableCell align="right">Serial Number</TableCell>
                        <TableCell align="right">Registration</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {aircrafts.map((aircraft) => (
                        <TableRow
                            key={aircraft.id}
                            sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                        >
                            <TableCell>
                                <Link to={`/aircraft/${aircraft.id}`}>{aircraft.model}</Link>
                            </TableCell>
                            <TableCell align="right">{aircraft.serial_number}</TableCell>
                            <TableCell align="right">{aircraft.registration}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </TableContainer>
    </div>
}
