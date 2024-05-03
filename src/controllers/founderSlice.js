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
    bio: '',
    frameworks: '',
    skills: '',
    technologies: '',
    socialNetworks: '',
    resume: ''
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

export const getFoundersWithTerm = createAsyncThunk('founder/getFoundersWithTerm', async ({taxonomy, term}) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/founders/taxonomies/${taxonomy}`, {
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

export const founderSlice = createSlice({
    name: 'founder',
    initialState,
    extraReducers: (builder) => {
        builder
            .addMatcher(isAnyOf(
                getFounders.fulfilled,
                getFoundersWithTerm.fulfilled
            ), (state, action) => {
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
                state.fullName = action.payload.full_name
                state.bio = action.payload.bio
                state.frameworks = action.payload.frameworks
                state.skills = action.payload.skills
                state.technologies = action.payload.technologies
                state.socialNetworks = action.payload.social_networks
                state.resume = action.payload.resume
            })
            .addMatcher(isAnyOf(
                getFounders.pending,
                getFounder.pending
            ), (state) => {
                state.founderLoading = true
                state.founderStatusCode = ''
                state.founderErrorMessage = ''
                state.founderError = ''
            })
            .addMatcher(isAnyOf(
                getFounders.rejected,
                getFounder.rejected
            ), (state, action) => {
                state.founderLoading = false
                state.founderStatusCode = action.error.code
                state.founderErrorMessage = action.error.message
                state.founderError = action.error
            })
    }
})

export default founderSlice;