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

export default ({ mode = 'create', data = { description: '', priority: '', due_date: '', aircraft_id: '', maintenance_company_id: '' }, url = '/', afterUpdate = () => {}}) => {
    const [maintenanceCompanies, setMaintenanceCompanies] = useState([]);
    const [aircrafts, setAircrafts] = useState([]);
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

    useEffect(() => {
        async function loadData() {
            const response = await axios.get("/api/maintenanceCompany");
            const aircraftsResponse = await axios.get("/api/aircraft");
            setMaintenanceCompanies(response.data.data);
            setAircrafts(aircraftsResponse.data.data);
        }
        loadData();
    }, []);

    const hasError = field => errorFields.indexOf(field) > -1;

    return <form method={'post'} className={'mt-6'} onSubmit={handleSubmit(onSubmit)}>
        <TextField id="description" label="Description" variant="outlined" fullWidth={true} multiline={true} {...register('description')}
                   error={hasError('description')}
                   helperText={fieldErrors('description')}
        />
        <div className={"mb-6"}></div>

        <TextField type={'date'} id="due_date" label="Due Date" variant="outlined" fullWidth={true} {...register('due_date')}
                   error={hasError('due_date')}
                   helperText={fieldErrors('due_date')} />
        <div className={"mb-6"}></div>

        <FormControl fullWidth error={hasError('priority')}>
            <FormLabel id="priority-label">Priority</FormLabel>
            <Controller render={({field}) => (
                <RadioGroup
                    aria-labelledby="priority-label"
                    defaultValue="female"
                    name="radio-buttons-group"
                    {...field}
                >
                    <FormControlLabel value="low" control={<Radio />} label="Low" />
                    <FormControlLabel value="medium" control={<Radio />} label="Medium" />
                    <FormControlLabel value="high" control={<Radio />} label="High" />
                </RadioGroup>
            )}
                        defaultValue={''}
                        name="priority"
                        control={control}
            />
            {hasError('priority') && (<FormHelperText>{fieldErrors('priority')}</FormHelperText>)}
        </FormControl>
        <div className={'mt-6'}></div>

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
        <div className={'mt-6'}></div>

        <FormControl fullWidth error={hasError('aircraft_id')}>
            <InputLabel id="maintenance-company-select-label">Aircraft</InputLabel>
            <Controller render={({field}) => (
                <Select
                    labelId="aircraft-select-label"
                    id="aircraft-select"
                    label="Aircraft"
                    {...field}
                >
                    {aircrafts.map(aircraft => <MenuItem value={aircraft.id} key={aircraft.id}>{aircraft.model} ({aircraft.serial_number})</MenuItem>)}
                </Select>
            )}
                        defaultValue={''}
                        name="aircraft_id"
                        control={control}
            />
            {hasError('aircraft_id') && (<FormHelperText>{fieldErrors('aircraft_id')}</FormHelperText>)}
        </FormControl>

        <div className={"mt-6 pt-6 border-t flex"}>
            <div className={'ml-auto'}>
                <Button variant={"contained"} type={'submit'}>{mode === 'create' ? 'Create' : 'Update'}</Button>
            </div>
        </div>
    </form>
}
