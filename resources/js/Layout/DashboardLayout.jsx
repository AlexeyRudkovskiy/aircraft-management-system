import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import Button from '@mui/material/Button';
import IconButton from '@mui/material/IconButton';
import MenuIcon from '@mui/icons-material/Menu';
import {
    Divider,
    Drawer,
    List,
    ListItem,
    ListItemButton,
    ListItemIcon,
    ListItemText,
    MenuItem,
    MenuList
} from "@mui/material";
import {ContentCut} from "@mui/icons-material";
import NavigationLink from "../Components/NavigationLink.jsx";


export default ({ children }) => {
    return (<>
        <Box sx={{ flexGrow: 1 }} className="z-20 relative">
            <AppBar position="static">
                <Toolbar>
                    <IconButton
                        size="large"
                        edge="start"
                        color="inherit"
                        aria-label="menu"
                        sx={{ mr: 2 }}
                    >
                        <MenuIcon />
                    </IconButton>
                    <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
                        News
                    </Typography>
                    <Button color="inherit">Login</Button>
                </Toolbar>
            </AppBar>
        </Box>

        <div className="application-container">
            <div className="sidebar w-80 shrink-0 grow-0 relative border-r">
                <div className="py-4">
                    <NavigationLink>Aircrafts</NavigationLink>
                    <NavigationLink>Maintenance Companies</NavigationLink>
                    <NavigationLink>Service Requests</NavigationLink>
                </div>
            </div>
            <Box className="content w-full p-4" sx={{ backgroundColor: theme => theme.palette.grey[100] }}>
                {children}
            </Box>
        </div>

        </>);
}
