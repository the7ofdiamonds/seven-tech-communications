import { createSlice, createAsyncThunk, isAnyOf } from '@reduxjs/toolkit';

const initialState = {
    executiveLoading: false,
    executiveStatusCode: '',
    executiveError: '',
    executiveErrorMessage: '',
    executives: '',
    title: '',
    avatarURL: '',
    authorURL: '',
    fullName: '',
    bio: '',
    skills: '',
    socialNetworks: '',
    resume: ''
};

export const getExecutives = createAsyncThunk('executive/getExecutives', async () => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/executives`, {
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

export const getExecutivesWithTerm = createAsyncThunk('executive/getExecutivesWithTerm', async ({ taxonomy, term }) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/executives/taxonomies/${taxonomy}`, {
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

export const getExecutive = createAsyncThunk('executive/getExecutive', async (executive) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/executives/${executive}`, {
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

export const executiveSlice = createSlice({
    name: 'executive',
    initialState,
    extraReducers: (builder) => {
        builder
            .addMatcher(isAnyOf(
                getExecutives.fulfilled,
                getExecutivesWithTerm.fulfilled
            ), (state, action) => {
                state.executiveLoading = false;
                state.executiveStatusCode = action.payload.statusCode
                state.executiveErrorMessage = action.payload.errorMessage
                state.executives = action.payload.executives
            })
            .addCase(getExecutive.fulfilled, (state, action) => {
                state.executiveLoading = false
                state.executiveError = null
                state.title = action.payload.title
                state.authorURL = action.payload.author_url
                state.avatarURL = action.payload.avatar_url
                state.fullName = action.payload.full_name
                state.bio = action.payload.bio
                state.frameworks = action.payload.frameworks
                state.skills = action.payload.skills
                state.technologies = action.payload.technologies
                state.socialNetworks = action.payload.social_networks
                state.resume = action.payload.resume
            })
            .addMatcher(isAnyOf(
                getExecutives.pending,
                getExecutive.pending
            ), (state) => {
                state.executiveLoading = true
                state.executiveStatusCode = ''
                state.executiveErrorMessage = ''
                state.executiveError = ''
            })
            .addMatcher(isAnyOf(
                getExecutives.rejected,
                getExecutive.rejected
            ), (state, action) => {
                state.executiveLoading = false
                state.executiveStatusCode = action.error.code
                state.executiveErrorMessage = action.error.message
                state.executiveError = action.error
            })
    }
})

export default executiveSlice;