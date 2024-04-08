import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';

const initialState = {
    aboutLoading: false,
    aboutStatusCode: '',
    aboutError: '',
    aboutErrorMessage: '',
    missionStatement: '',
};

export const getMissionStatement = createAsyncThunk('about/getMissionStatement', async (pageSlug) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/about/mission-statement`, {
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

export const aboutSlice = createSlice({
    name: 'about',
    initialState,
    extraReducers: (builder) => {
        builder
            .addCase(getMissionStatement.pending, (state) => {
                state.aboutLoading = true
                state.aboutStatusCode = ''
                state.aboutError = ''
                state.aboutErrorMessage = ''
            })
            .addCase(getMissionStatement.fulfilled, (state, action) => {
                state.aboutLoading = false;
                state.aboutStatusCode = action.payload.statusCode;
                state.aboutError = action.payload.error;
                state.aboutErrorMessage = action.payload.errorMessage;
                state.missionStatement = action.payload.missionStatement
            })
            .addCase(getMissionStatement.rejected, (state, action) => {
                state.aboutLoading = false
                state.aboutStatusCode = action.error.code
                state.aboutError = action.error
                state.aboutErrorMessage = action.error.message
            })
    }
})

export default aboutSlice;