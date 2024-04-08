import { configureStore } from '@reduxjs/toolkit';

import { contentSlice } from '../controllers/contentSlice.js';

const store = configureStore({
    reducer: {
        content: contentSlice.reducer,
    }
});

export default store;