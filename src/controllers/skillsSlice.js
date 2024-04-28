import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';

const initialState = {
    skillsLoading: false,
    skillsStatusCode: '',
    skillsError: '',
    skillsErrorMessage: '',
    skills: '',
    title: '',
    authorURL: '',
    avatarURL: '',
    fullName: '',
    bio: ''
};

export const getSkills = createAsyncThunk('skills/getSkills', async () => {

    try {
        const response = await fetch(`/wp-json/seven-tech/communications/v1/taxonomies/skills`, {
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

export const getSkill = createAsyncThunk('skills/getSkill', async (skills) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/communications/v1/taxonomies/skills/${skills}`, {
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

export const skillsSlice = createSlice({
    name: 'skills',
    initialState,
    extraReducers: (builder) => {
        builder
            .addCase(getSkills.pending, (state) => {
                state.skillsLoading = true
                state.skillsError = ''
            })
            .addCase(getSkills.fulfilled, (state, action) => {
                state.skillsLoading = false;
                state.skillsError = null;
                state.skillsErrorMessage = action.payload.errorMessage;
                state.skillsStatusCode = action.payload.statusCode;
                state.skills = action.payload.skills;
            })
            .addCase(getSkill.pending, (state) => {
                state.skillsLoading = true
                state.skillsError = ''
            })
            .addCase(getSkill.fulfilled, (state, action) => {
                state.skillsLoading = false
                state.skillsError = null
                state.title = action.payload.title
                state.authorURL = action.payload.author_url
                state.avatarURL = action.payload.avatar_url
                state.fullName = action.payload.full_name
                state.bio = action.payload.bio
                state.skills = action.payload.skills
                state.skillsResume = action.payload.skillsResume
            })
            .addCase(getSkill.rejected, (state, action) => {
                state.skillsLoading = false
                state.skillsError = action.error.message
            })
    }
})

export default skillsSlice;