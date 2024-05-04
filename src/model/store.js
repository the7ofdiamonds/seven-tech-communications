import { configureStore } from '@reduxjs/toolkit';

import { aboutSlice } from '../controllers/aboutSlice.js';
import { contactSlice } from '../controllers/contactSlice.js';
import { contentSlice } from '../controllers/contentSlice.js';
import { employeeSlice } from '../controllers/employeeSlice.js';
import { executiveSlice } from '../controllers/executiveSlice.js';
import { founderSlice } from '../controllers/founderSlice.js';
import { freelancerSlice } from '../controllers/freelancerSlice.js';
import { investorSlice } from '../controllers/investorSlice.js';
import { managingMemberSlice } from '../controllers/managingMemberSlice.js';
import { taxonomiesSlice } from '../controllers/taxonomiesSlice';

const store = configureStore({
    reducer: {
        about: aboutSlice.reducer,
        contact: contactSlice.reducer,
        content: contentSlice.reducer,
        employee: employeeSlice.reducer,
        executive: executiveSlice.reducer,
        founder: founderSlice.reducer,
        freelancer: freelancerSlice.reducer,
        investor: investorSlice.reducer,
        managingMember: managingMemberSlice.reducer,
        taxonomies: taxonomiesSlice.reducer
    }
});

export default store;