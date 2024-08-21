import {Chip} from "@mui/material";

export default ({ priority }) => {
    const getText = p => {
        switch (p) {
            case 'low': return 'Low';
            case 'medium': return 'Medium';
            case 'high': return 'High';
            default: return 'Undefined';
        }
    }

    const getVariant = p => {
        switch (p) {
            case 'low': return 'primary';
            case 'medium': return 'warning';
            case 'high': return 'error';
            default: return 'primary';
        }
    }

    return <Chip label={getText(priority)} color={getVariant(priority)} />
}
