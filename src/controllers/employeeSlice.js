import { createSlice, createAsyncThunk, isAnyOf } from '@reduxjs/toolkit';

const initialState = {
    employeeLoading: false,
    employeeStatusCode: '',
    employeeError: '',
    employeeErrorMessage: '',
    employees: '',
    title: '',
    avatarURL: '',
    authorURL: '',
    fullName: '',
    bio: '',
    skills: '',
    socialNetworks: '',
    resume: ''
};

export const getEmployees = createAsyncThunk('employee/getEmployees', async () => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/employees`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        });

        const responseData = await response.json();

        return responseData;
    } catch (error) {
        console.error(error);
        throw new Error(error.message);
    }
});

export const getEmployeesWithTerm = createAsyncThunk('employee/getEmployeesWithTerm', async ({taxonomy, term}) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/employees/taxonomies/${taxonomy}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                term: term
            })
        });

        const responseData = await response.json();

        return responseData;
    } catch (error) {
        console.error(error);
        throw new Error(error.message);
    }
});

export const getEmployee = createAsyncThunk('employee/getEmployee', async (employee) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/employees/${employee}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        });

        const responseData = await response.json();

        return responseData;
    } catch (error) {
        console.error(error);
        throw new Error(error.message);
    }
});

export const employeeSlice = createSlice({
    name: 'employee',
    initialState,
    extraReducers: (builder) => {
        builder
            .addMatcher(isAnyOf(
                getEmployees.fulfilled,
                getEmployeesWithTerm.fulfilled
            ), (state, action) => {
                state.employeeLoading = false;
                state.employeeStatusCode = action.payload.statusCode
                state.employeeErrorMessage = action.payload.errorMessage
                state.employees = action.payload.employees
            })
            .addCase(getEmployee.fulfilled, (state, action) => {
                state.employeeLoading = false
                state.employeeError = null
                state.title = action.payload.title
                state.authorURL = action.payload.author_url
                state.avatarURL = action.payload.avatar_url
                state.fullName = action.payload.full_name
                state.bio = action.payload.bio
                state.skills = action.payload.skills
                state.socialNetworks = action.payload.social_networks
                state.resume = action.payload.resume
            })
            .addMatcher(isAnyOf(
                getEmployees.pending,
                getEmployee.pending
            ), (state) => {
                state.employeeLoading = true
                state.employeeStatusCode = ''
                state.employeeErrorMessage = ''
                state.employeeError = ''
            })
            .addMatcher(isAnyOf(
                getEmployees.rejected,
                getEmployee.rejected
            ), (state, action) => {
                state.employeeLoading = false
                state.employeeStatusCode = action.error.code
                state.employeeErrorMessage = action.error.message
                state.employeeError = action.error
            })
    }
})

export default employeeSlice;