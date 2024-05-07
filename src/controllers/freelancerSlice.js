import { createSlice, createAsyncThunk, isAnyOf } from '@reduxjs/toolkit';

const initialState = {
    freelancerLoading: false,
    freelancerStatusCode: '',
    freelancerError: '',
    freelancerErrorMessage: '',
    freelancers: '',
    title: '',
    avatarURL: '',
    authorURL: '',
    fullName: '',
    bio: '',
    skills: '',
    socialNetworks: '',
    resume: '',
    content: ''
};

export const getFreelancers = createAsyncThunk('freelancer/getFreelancers', async () => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/freelancers`, {
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

export const getFreelancersWithTerm = createAsyncThunk('freelancer/getFreelancersWithTerm', async ({ taxonomy, term }) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/freelancers/taxonomies/${taxonomy}`, {
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

export const getFreelancer = createAsyncThunk('freelancer/getFreelancer', async (freelancer) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/freelancers/${freelancer}`, {
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

export const freelancerSlice = createSlice({
    name: 'freelancer',
    initialState,
    extraReducers: (builder) => {
        builder
            .addMatcher(isAnyOf(
                getFreelancers.fulfilled,
                getFreelancersWithTerm.fulfilled
            ), (state, action) => {
                state.freelancerLoading = false;
                state.freelancerStatusCode = action.payload.statusCode
                state.freelancerErrorMessage = action.payload.errorMessage
                state.freelancers = action.payload.freelancers
            })
            .addCase(getFreelancer.fulfilled, (state, action) => {
                state.freelancerLoading = false
                state.freelancerError = null
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
                state.content = action.payload.content
            })
            .addMatcher(isAnyOf(
                getFreelancers.pending,
                getFreelancer.pending
            ), (state) => {
                state.freelancerLoading = true
                state.freelancerStatusCode = ''
                state.freelancerErrorMessage = ''
                state.freelancerError = ''
            })
            .addMatcher(isAnyOf(
                getFreelancers.rejected,
                getFreelancer.rejected
            ), (state, action) => {
                state.freelancerLoading = false
                state.freelancerStatusCode = action.error.code
                state.freelancerErrorMessage = action.error.message
                state.freelancerError = action.error
            })
    }
})

export default freelancerSlice;