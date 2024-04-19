import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';

const initialState = {
    teamLoading: false,
    teamError: '',
    team: '',
    title: '',
    author_url: '',
    avatar_url: '',
    fullName: '',
    greeting: '',
    skills: '',
    teamResume: ''
};

export const getTeam = createAsyncThunk('team/getTeam', async () => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/users/team`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        });

        if (!response.ok) {
            const errorData = await response.json();
            const errorMessage = errorData.message;
            throw new Error(errorMessage);
        }

        const responseData = await response.json();
        return responseData;
    } catch (error) {
        throw error;
    }
});

export const getTeamMember = createAsyncThunk('team/getTeamMember', async (team) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/users/team/${team}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        });

        if (!response.ok) {
            const errorData = await response.json();
            const errorMessage = errorData.message;
            throw new Error(errorMessage);
        }

        const responseData = await response.json();
        return responseData;
    } catch (error) {
        throw error;
    }
});

export const getTeamMemberResume = createAsyncThunk('team/getTeamMemberResume', async (pageTitle) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/users/team/${pageTitle}/resume`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        });

        if (!response.ok) {
            const errorData = await response.json();
            const errorMessage = errorData.message;
            throw new Error(errorMessage);
        }

        const responseData = await response.json();
        return responseData;
    } catch (error) {
        throw error;
    }
});

export const teamSlice = createSlice({
    name: 'team',
    initialState,
    extraReducers: (builder) => {
        builder
            .addCase(getTeam.pending, (state) => {
                state.teamLoading = true
                state.teamError = ''
            })
            .addCase(getTeam.fulfilled, (state, action) => {
                state.teamLoading = false;
                state.teamError = null;
                state.team = action.payload
            })
            .addCase(getTeam.rejected, (state, action) => {
                state.teamLoading = false
                state.teamError = action.error.message
            })
            .addCase(getTeamMember.pending, (state) => {
                state.teamLoading = true
                state.teamError = ''
            })
            .addCase(getTeamMember.fulfilled, (state, action) => {
                state.teamLoading = false
                state.teamError = null
                state.title = action.payload.title
                state.authorURL = action.payload.author_url
                state.avatarURL = action.payload.avatar_url
                state.fullName = action.payload.fullName
                state.greeting = action.payload.greeting
                state.skills = action.payload.skills
                state.teamResume = action.payload.teamResume
            })
            .addCase(getTeamMember.rejected, (state, action) => {
                state.teamLoading = false
                state.teamError = action.error.message
            })
            .addCase(getTeamMemberResume.pending, (state) => {
                state.teamLoading = true
                state.teamError = ''
            })
            .addCase(getTeamMemberResume.fulfilled, (state, action) => {
                state.teamLoading = false;
                state.teamError = null;
                state.teamResume = action.payload
            })
            .addCase(getTeamMemberResume.rejected, (state, action) => {
                state.teamLoading = false
                state.teamError = action.error.message
            })

    }
})

export default teamSlice;