import {useEffect, useState} from "react";
import {useNavigate} from "react-router-dom";
import {Controller, useForm} from "react-hook-form";
import Typography from "@mui/material/Typography";
import {FormControl, FormHelperText, InputLabel, MenuItem, Select, TextField} from "@mui/material";
import Button from "@mui/material/Button";

export default ({ mode = 'create', data = { name: '', contact: '', specialization: '' }, url = '/', afterUpdate = () => {}}) => {
    const [errors, setErrors] = useState({});
    const [errorFields, setErrorFields] = useState([]);
    const navigate = useNavigate();
    const {
        register,
        control,
        handleSubmit
    } = useForm({
        defaultValues: data
    });

    const onSubmit = async (data) => {
        try {
            let response = null;
            if (mode === 'create') {
                response = await axios.post(url, { ...data })
            } else {
                response = await axios.put(url, { ...data })
            }

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
        <TextField id="name" label="Name" variant="outlined" fullWidth={true} {...register('name')}
                   error={hasError('name')}
                   helperText={fieldErrors('name')}
        />
        <div className={"mb-6"}></div>

        <TextField id="contact" label="Contact" variant="outlined" fullWidth={true} {...register('contact')}
                   error={hasError('contact')}
                   helperText={fieldErrors('contact')} />
        <div className={"mb-6"}></div>

        <TextField id="specialization" label="Specialization" variant="outlined" fullWidth={true} {...register('specialization')}
                   error={hasError('specialization')}
                   helperText={fieldErrors('specialization')} />
        <div className={"mb-6"}></div>

        <div className={"mt-6 pt-6 border-t flex"}>
            <div className={'ml-auto'}>
                <Button variant={"contained"} type={'submit'}>{mode === 'create' ? 'Create' : 'Update'}</Button>
            </div>
        </div>
    </form>
}
