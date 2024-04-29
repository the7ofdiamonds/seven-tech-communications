import { configureStore } from '@reduxjs/toolkit';

import { aboutSlice } from '../controllers/aboutSlice.js';
import { contactSlice } from '../controllers/contactSlice.js';
import { contentSlice } from '../controllers/contentSlice.js';
import { founderSlice } from '../controllers/founderSlice.js';
import { teamSlice } from '../controllers/teamSlice.js';
import { taxonomiesSlice } from '../controllers/taxonomiesSlice';

const store = configureStore({
    reducer: {
        about: aboutSlice.reducer,
        contact: contactSlice.reducer,
        content: contentSlice.reducer,
        founder: founderSlice.reducer,
        team: teamSlice.reducer,
        taxonomies: taxonomiesSlice.reducer        
    }
});

export default store;