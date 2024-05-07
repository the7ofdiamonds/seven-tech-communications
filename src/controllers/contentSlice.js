import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';

const initialState = {
    contentLoading: false,
    contentStatusCode: '',
    contentError: '',
    contentErrorMessage: '',
    content: '',
    title: ''
};

export const getContent = createAsyncThunk('content/getContent', async (pageSlug) => {

    try {
        const response = await fetch(`/wp-json/seven-tech/communications/v1/content/${pageSlug}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const responseData = await response.json();

        return responseData;
    } catch (error) {
        console.error(error);
        throw new Error(error.message);
    }
});

export const contentSlice = createSlice({
    name: 'content',
    initialState,
    extraReducers: (builder) => {
        builder
            .addCase(getContent.pending, (state) => {
                state.contentLoading = true
                state.contentStatusCode = '';
                state.contentError = '';
                state.contentErrorMessage = '';
            })
            .addCase(getContent.fulfilled, (state, action) => {
                state.contentLoading = false;
                state.contentStatusCode = action.payload.statusCode;
                state.contentError = action.payload.error;
                state.contentErrorMessage = action.payload.errorMessage;
                state.content = action.payload.content;
                state.title = action.payload.title;
            })
            .addCase(getContent.rejected, (state, action) => {
                state.contentLoading = false
                state.contentStatusCode = action.error.code;
                state.contentError = action.error;
                state.contentErrorMessage = action.error.message;
            })
    }
})

export default contentSlice;