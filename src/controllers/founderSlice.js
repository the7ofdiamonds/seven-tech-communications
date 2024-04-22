import { createSlice, createAsyncThunk, isAnyOf } from '@reduxjs/toolkit';

const initialState = {
    founderLoading: false,
    founderStatusCode: '',
    founderError: '',
    founderErrorMessage: '',
    founders: '',
    title: '',
    avatarURL: '',
    authorURL: '',
    fullName: '',
    greeting: '',
    skills: '',
    social_networks: '',
    founder_resume: ''
};

export const getFounders = createAsyncThunk('founder/getFounders', async () => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/founders`, {
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

export const getFounder = createAsyncThunk('founder/getFounder', async (founder) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/founders/${founder}`, {
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

export const getFounderResume = createAsyncThunk('founder/getFounderResume', async (pageTitle) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/founders/${pageTitle}/resume`, {
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

export const founderSlice = createSlice({
    name: 'founder',
    initialState,
    extraReducers: (builder) => {
        builder
            .addCase(getFounders.fulfilled, (state, action) => {
                state.founderLoading = false;
                state.founderStatusCode = action.payload.statusCode
                state.founderErrorMessage = action.payload.errorMessage
                state.founders = action.payload.founders
            })
            .addCase(getFounder.fulfilled, (state, action) => {
                state.founderLoading = false
                state.founderError = null
                state.title = action.payload.title
                state.authorURL = action.payload.author_url
                state.avatarURL = action.payload.avatar_url
                state.fullName = action.payload.fullName
                state.greeting = action.payload.greeting
                state.skills = action.payload.skills
                state.social_networks = action.payload.social_networks
                state.founder_resume = action.payload.founder_resume
            })
            .addCase(getFounderResume.fulfilled, (state, action) => {
                state.founderLoading = false;
                state.founderError = null;
                state.founder_resume = action.payload
            })
            .addMatcher(isAnyOf(
                getFounders.pending,
                getFounder.pending,
                getFounderResume.pending
            ), (state) => {
                state.founderLoading = true
                state.founderStatusCode = ''
                state.founderErrorMessage = ''
                state.founderError = ''
            })
            .addMatcher(isAnyOf(
                getFounders.rejected,
                getFounder.rejected,
                getFounderResume.rejected
            ), (state, action) => {
                state.founderLoading = false
                state.founderStatusCode = action.error.code
                state.founderErrorMessage = action.error.message
                state.founderError = action.error
            })
    }
})

export default founderSlice;