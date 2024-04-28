import { configureStore } from '@reduxjs/toolkit';

import { aboutSlice } from '../controllers/aboutSlice.js';
import { contactSlice } from '../controllers/contactSlice.js';
import { contentSlice } from '../controllers/contentSlice.js';
import { founderSlice } from '../controllers/founderSlice.js';
import { teamSlice } from '../controllers/teamSlice.js';
import { skillsSlice} from '../controllers/skillsSlice.js';

const store = configureStore({
    reducer: {
        about: aboutSlice.reducer,
        contact: contactSlice.reducer,
        content: contentSlice.reducer,
        founder: founderSlice.reducer,
        team: teamSlice.reducer,
        skills: skillsSlice.reducer
    }
});

export default store;