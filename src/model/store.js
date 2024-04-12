import { configureStore } from '@reduxjs/toolkit';

import { aboutSlice } from '../controllers/aboutSlice.js';
import { contactSlice } from '../controllers/contactSlice.js';
import { contentSlice } from '../controllers/contentSlice.js';

const store = configureStore({
    reducer: {
        about: aboutSlice.reducer,
        contact: contactSlice.reducer,
        content: contentSlice.reducer,
    }
});

export default store;