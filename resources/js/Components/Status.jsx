import {Chip} from "@mui/material";

export default ({ status }) => {
    const getText = p => {
        switch (p) {
            case 'pending': return 'Pending';
            case 'in_progress': return 'In Progress';
            case 'completed': return 'Completed';
            default: return 'Undefined';
        }
    }

    const getVariant = p => {
        switch (p) {
            case 'pending': return 'primary';
            case 'in_progress': return 'warning';
            case 'completed': return 'success';
            default: return 'primary';
        }
    }

    return <Chip label={getText(status)} color={getVariant(status)} />;
}
