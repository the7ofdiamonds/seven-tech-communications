import { createSlice, createAsyncThunk, isAnyOf } from '@reduxjs/toolkit';

const initialState = {
    managingMemberLoading: false,
    managingMemberStatusCode: '',
    managingMemberError: '',
    managingMemberErrorMessage: '',
    managingMembers: '',
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

export const getManagingMembers = createAsyncThunk('managingMember/getManagingMembers', async () => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/managing-members`, {
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

export const getManagingMembersWithTerm = createAsyncThunk('managingMember/getManagingMembersWithTerm', async ({ taxonomy, term }) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/managing-members/taxonomies/${taxonomy}`, {
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

export const getManagingMember = createAsyncThunk('managingMember/getManagingMember', async (managingMember) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/managing-members/${managingMember}`, {
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

export const managingMemberSlice = createSlice({
    name: 'managingMember',
    initialState,
    extraReducers: (builder) => {
        builder
            .addMatcher(isAnyOf(
                getManagingMembers.fulfilled,
                getManagingMembersWithTerm.fulfilled
            ), (state, action) => {
                state.managingMemberLoading = false;
                state.managingMemberStatusCode = action.payload.statusCode
                state.managingMemberErrorMessage = action.payload.errorMessage
                state.managingMembers = action.payload.managing_members
            })
            .addCase(getManagingMember.fulfilled, (state, action) => {
                state.managingMemberLoading = false
                state.managingMemberError = null
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
                getManagingMembers.pending,
                getManagingMember.pending
            ), (state) => {
                state.managingMemberLoading = true
                state.managingMemberStatusCode = ''
                state.managingMemberErrorMessage = ''
                state.managingMemberError = ''
            })
            .addMatcher(isAnyOf(
                getManagingMembers.rejected,
                getManagingMember.rejected
            ), (state, action) => {
                state.managingMemberLoading = false
                state.managingMemberStatusCode = action.error.code
                state.managingMemberErrorMessage = action.error.message
                state.managingMemberError = action.error
            })
    }
})

export default managingMemberSlice;