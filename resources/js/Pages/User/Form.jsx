import {useEffect, useState} from "react";
import {useNavigate} from "react-router-dom";
import {Controller, useForm} from "react-hook-form";
import Typography from "@mui/material/Typography";
import {
    FormControl,
    FormControlLabel,
    FormHelperText, FormLabel,
    InputLabel,
    MenuItem,
    Radio, RadioGroup,
    Select,
    TextField
} from "@mui/material";
import Button from "@mui/material/Button";

export default ({ mode = 'create', data = { email: '', name: '' }, url = '/api/user', afterUpdate = () => {}}) => {
    const [maintenanceCompanies, setMaintenanceCompanies] = useState([]);
    const [aircrafts, setAircrafts] = useState([]);
    const [errors, setErrors] = useState({});
    const [errorFields, setErrorFields] = useState([]);
    const navigate = useNavigate();
    const {
        register,
        control,
        handleSubmit,
        resetField
    } = useForm({
        defaultValues: data
    });

    const onSubmit = async (data) => {
        try {
            let response = null;

            if (mode === 'create') {
                response = await axios.post(url, { ...data })
            } else {

                if (data.password.length < 1) {
                    delete data.password;
                }

                response = await axios.put(url, { ...data })
            }

            resetField('password')
            afterUpdate(response.data.data)
        } catch (error) {
            let validationErrors = error.response.data.errors;
            setErrorFields(Object.keys(validationErrors));
            setErrors(validationErrors);
        }
    }

    const fieldErrors = field => {
        if (!hasError(field) || typeof errors[field] === "undefined") {
            return '';
        }

        return errors[field].join('. ');
    }

    const hasError = field => errorFields.indexOf(field) > -1;

    return <form method={'post'} className={'mt-6'} onSubmit={handleSubmit(onSubmit)}>
        <TextField id="email" type={'email'} label="E-Mail" variant="outlined" fullWidth={true} multiline={true} {...register('email')}
                   error={hasError('email')}
                   helperText={fieldErrors('email')}
        />
        <div className={"mb-6"}></div>

        <TextField id="name" label="Name" variant="outlined" fullWidth={true} {...register('name')}
                   error={hasError('name')}
                   helperText={fieldErrors('name')} />
        <div className={"mb-6"}></div>

        <TextField type={'password'} id="password" label="Password" variant="outlined" fullWidth={true} {...register('password')}
                   error={hasError('password')}
                   helperText={fieldErrors('password')} />
        <div className={"mb-6"}></div>

        <div className={"mt-6 pt-6 border-t flex"}>
            <div className={'ml-auto'}>
                <Button variant={"contained"} type={'submit'}>{mode === 'create' ? 'Create' : 'Update'}</Button>
            </div>
        </div>
    </form>
}
