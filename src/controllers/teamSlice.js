import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';

const initialState = {
    teamLoading: false,
    teamStatusCode: '',
    teamError: '',
    teamErrorMessage: '',
    team: '',
    title: '',
    author_url: '',
    avatar_url: '',
    fullName: '',
    greeting: ''
};

export const getTeam = createAsyncThunk('team/getTeam', async () => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/team`, {
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

export const getTeamMember = createAsyncThunk('team/getTeamMember', async (team) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/team/${team}`, {
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
                state.teamErrorMessage = action.payload.errorMessage;
                state.teamStatusCode = action.payload.statusCode;
                state.team = action.payload.team;
            })
            .addCase(getTeam.rejected, (state, action) => {
                state.teamLoading = false
                state.teamError = action.error
                state.teamErrorMessage = action.error.message
                state.teamStatusCode = action.error.code
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
    }
})

export default teamSlice;