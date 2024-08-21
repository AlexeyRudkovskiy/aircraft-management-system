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
    const [maintenanceCompanies, setMaintenanceCompanies] = useState([]);

    useEffect(() => {
        async function loadAircraft() {
            const response = await axios.get('/api/maintenanceCompany');
            setMaintenanceCompanies(response.data.data);
        }
        loadAircraft();
    }, []);

    return <div>
        <div className={"flex align-items-center"}>
            <Typography variant={"h4"}>Maintenance Companies</Typography>
            <div className={"inline-block ml-4 flex align-items-center"}>
                <Button to={"/maintenance-company/create"} component={Link}>Add New</Button>
            </div>
        </div>

        <TableContainer component={Paper} className="mt-6">
            <Table sx={{ minWidth: 650 }} aria-label="simple table">
                <TableHead>
                    <TableRow>
                        <TableCell>Model</TableCell>
                        <TableCell align="right">Contact</TableCell>
                        <TableCell align="right">Specialization</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {maintenanceCompanies.map((company) => (
                        <TableRow
                            key={company.id}
                            sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                        >
                            <TableCell>
                                <Link to={`/maintenance-company/${company.id}`} className={'hover:underline text-sky-600'}>{company.name}</Link>
                            </TableCell>
                            <TableCell align="right">{company.contact}</TableCell>
                            <TableCell align="right">{company.specialization}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </TableContainer>
    </div>
}
