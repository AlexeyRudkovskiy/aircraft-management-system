import {useEffect, useState} from "react";
import {useNavigate} from "react-router-dom";
import {Controller, useForm} from "react-hook-form";
import Typography from "@mui/material/Typography";
import {FormControl, FormHelperText, InputLabel, MenuItem, Select, TextField} from "@mui/material";
import Button from "@mui/material/Button";

export default ({ mode = 'create', data = { model: '', serial_number: '', registration: '', maintenance_company_id: '' }, url = '/', afterUpdate = () => {}}) => {
    const [maintenanceCompanies, setMaintenanceCompanies] = useState([]);
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

    useEffect(() => {
        async function loadMaintenanceCompanies() {
            const response = await axios.get("/api/maintenanceCompany");
            setMaintenanceCompanies(response.data.data);
        }
        loadMaintenanceCompanies();
    }, []);

    const fieldErrors = field => {
        if (!hasError(field) || typeof errors[field] === "undefined") {
            return '';
        }

        return errors[field].join('. ');
    }

    const hasError = field => errorFields.indexOf(field) > -1;

    return <form method={'post'} className={'mt-6'} onSubmit={handleSubmit(onSubmit)}>
        <TextField id="outlined-basic" label="Model" variant="outlined" fullWidth={true} {...register('model')}
                   error={hasError('model')}
                   helperText={fieldErrors('model')}
        />
        <div className={"mb-6"}></div>

        <TextField id="outlined-basic" label="Serial Number" variant="outlined" fullWidth={true} {...register('serial_number')}
                   error={hasError('serial_number')}
                   helperText={fieldErrors('serial_number')} />
        <div className={"mb-6"}></div>

        <TextField id="outlined-basic" label="Registration" variant="outlined" fullWidth={true} {...register('registration')}
                   error={hasError('registration')}
                   helperText={fieldErrors('registration')} />
        <div className={"mb-6"}></div>

        <FormControl fullWidth error={hasError('maintenance_company_id')}>
            <InputLabel id="maintenance-company-select-label">Maintenance Company</InputLabel>
            <Controller render={({field}) => (
                <Select
                    labelId="maintenance-company-select-label"
                    id="maintenance-company-select"
                    label="Maintenance Company"
                    {...field}
                >
                    {maintenanceCompanies.map(company => <MenuItem value={company.id} key={company.id}>{company.name}</MenuItem>)}
                </Select>
            )}
                        defaultValue={''}
                        name="maintenance_company_id"
                        control={control}
            />
            {hasError('maintenance_company_id') && (<FormHelperText>{fieldErrors('maintenance_company_id')}</FormHelperText>)}
        </FormControl>

        <div className={"mt-6 pt-6 border-t flex"}>
            <div className={'ml-auto'}>
                <Button variant={"contained"} type={'submit'}>{mode === 'create' ? 'Create' : 'Update'}</Button>
            </div>
        </div>
    </form>
}
