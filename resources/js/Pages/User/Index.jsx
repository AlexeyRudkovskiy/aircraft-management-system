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
    const [users, setUsers] = useState([]);

    useEffect(() => {
        async function loadUsers() {
            const response = await axios.get('/api/user');
            setUsers(response.data.data);
        }
        loadUsers();
    }, []);

    return <div>
        <div className={"flex align-items-center"}>
            <Typography variant={"h4"}>Users</Typography>
            <div className={"inline-block ml-4 flex align-items-center"}>
                <Button to={"/user/create"} component={Link}>Add New</Button>
            </div>
        </div>

        <TableContainer component={Paper} className="mt-6">
            <Table sx={{ minWidth: 650 }}>
                <TableHead>
                    <TableRow>
                        <TableCell>Name</TableCell>
                        <TableCell>Email</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {users.map((user) => (
                        <TableRow
                            key={user.id}
                            sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                        >
                            <TableCell>
                                <Link to={`/user/${user.id}`} className={'hover:underline text-sky-600'}>{user.name}</Link>
                            </TableCell>
                            <TableCell>{user.email}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </TableContainer>
    </div>
}
