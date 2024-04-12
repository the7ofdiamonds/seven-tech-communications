import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';

const initialState = {
    contactLoading: false,
    contactStatusCode: '',
    contactError: '',
    contactErrorMessage: '',
    contactSuccessMessage: ''
};

export const sendEmail = createAsyncThunk('contact/sendEmail', async ({ page, firstname, lastname, email, subject, msg }) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/email/${page}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                firstname: firstname,
                lastname: lastname,
                subject: subject,
                message: msg
            })
        });

        const responseData = await response.json();

        return responseData;
    } catch (error) {
        console.error(error);
        throw new Error(error.message);
    }
});

export const contactSlice = createSlice({
    name: 'contact',
    initialState,
    extraReducers: (builder) => {
        builder
            .addCase(sendEmail.pending, (state) => {
                state.contactLoading = true
                state.contactStatusCode = '';
                state.contactError = '';
                state.contactErrorMessage = '';
            })
            .addCase(sendEmail.fulfilled, (state, action) => {
                state.contactLoading = false;
                state.contactStatusCode = action.payload.statusCode;
                state.contactError = action.payload.error;
                state.contactErrorMessage = action.payload.errorMessage;
                state.contactSuccessMessage = action.payload.successMessage;
            })
            .addCase(sendEmail.rejected, (state, action) => {
                state.contactLoading = false
                state.contactStatusCode = action.error.code;
                state.contactError = action.error;
                state.contactErrorMessage = action.error.message;
            })
    }
})

export default contactSlice;