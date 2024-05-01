import { createSlice, createAsyncThunk, isAnyOf } from '@reduxjs/toolkit';

const initialState = {
    investorLoading: false,
    investorStatusCode: '',
    investorError: '',
    investorErrorMessage: '',
    investors: '',
    title: '',
    avatarURL: '',
    authorURL: '',
    fullName: '',
    bio: '',
    skills: '',
    socialNetworks: '',
    resume: ''
};

export const getInvestors = createAsyncThunk('investor/getInvestors', async () => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/investors`, {
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

export const getInvestorsWithTerm = createAsyncThunk('investor/getInvestorsWithTerm', async ({taxonomy, term}) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/investors/taxonomies/${taxonomy}`, {
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

export const getInvestor = createAsyncThunk('investor/getInvestor', async (investor) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/investors/${investor}`, {
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

export const investorSlice = createSlice({
    name: 'investor',
    initialState,
    extraReducers: (builder) => {
        builder
            .addMatcher(isAnyOf(
                getInvestors.fulfilled,
                getInvestorsWithTerm.fulfilled
            ), (state, action) => {
                state.investorLoading = false;
                state.investorStatusCode = action.payload.statusCode
                state.investorErrorMessage = action.payload.errorMessage
                state.investors = action.payload.investors
            })
            .addCase(getInvestor.fulfilled, (state, action) => {
                state.investorLoading = false
                state.investorError = null
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
                getInvestors.pending,
                getInvestor.pending
            ), (state) => {
                state.investorLoading = true
                state.investorStatusCode = ''
                state.investorErrorMessage = ''
                state.investorError = ''
            })
            .addMatcher(isAnyOf(
                getInvestors.rejected,
                getInvestor.rejected
            ), (state, action) => {
                state.investorLoading = false
                state.investorStatusCode = action.error.code
                state.investorErrorMessage = action.error.message
                state.investorError = action.error
            })
    }
})

export default investorSlice;