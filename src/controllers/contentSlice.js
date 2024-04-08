import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';

const initialState = {
    contentLoading: false,
    contentError: '',
    content: '',
    headquarters: ''
};

export const getContent = createAsyncThunk('content/getContent', async (pageSlug) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/v1/content/${pageSlug}`, {
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

export const contentSlice = createSlice({
    name: 'content',
    initialState,
    extraReducers: (builder) => {
        builder
            .addCase(getContent.pending, (state) => {
                state.contentLoading = true
                state.contentError = ''
            })
            .addCase(getContent.fulfilled, (state, action) => {
                state.contentLoading = false;
                state.contentError = null;
                state.content = action.payload
            })
            .addCase(getContent.rejected, (state, action) => {
                state.contentLoading = false
                state.contentError = action.error.message
            })
    }
})

export default contentSlice;