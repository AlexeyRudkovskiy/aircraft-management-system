import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import {TextField} from "@mui/material";
import {useForm} from "react-hook-form";
import Button from "@mui/material/Button";
import {useNavigate} from "react-router-dom";
import {useEffect, useState} from "react";

export default () => {
    const { register, handleSubmit } = useForm();
    const [loading, setLoading] = useState(true);
    const [errorMessage, setErrorMessage] = useState('')
    const navigate = useNavigate();

    useEffect(() => {
        async function checkUser() {
            try {
                const response = await axios.get('/api/me');
                navigate('/')
            } catch (error) {
                /// OK
            }
            setLoading(false);
        }
        checkUser();
    }, [])

    const onSubmit = async data => {
        try {
            const response = await axios.post('/login', data);
            navigate('/')
        } catch (error) {
            setErrorMessage(error.response.data.message);
        }
    }

    if (loading) {
        return <div>Loading...</div>;
    }

    return <Box
        className={'w-screen h-screen flex items-center justify-center'}
        sx={{ backgroundColor: theme => theme.palette.grey[100] }}>
        <form className={'rounded-xl shadow-md bg-white p-8 w-96'} onSubmit={handleSubmit(onSubmit)} method={'post'}>
            <Typography variant={'h5'}>Login</Typography>
            <div className={'mt-6'}></div>

            {errorMessage.length > 0 && <div className={'mb-8'}>
                <Typography color={'error'}>{errorMessage}</Typography>
            </div>}

            <TextField type={'email'} label="E-Mail" variant="outlined" fullWidth={true} {...register('email')} />
            <div className={'mt-6'}></div>

            <TextField type={'password'} label="Password" variant="outlined" fullWidth={true} {...register('password')} />
            <div className={'mt-6'}></div>

            <div className={'flex'}>
                <div className={'ml-auto'}>
                    <Button type={'submit'} variant={'contained'}>Sign In</Button>
                </div>
            </div>
        </form>
    </Box>;
}
