import { createSlice, createAsyncThunk, isAnyOf } from '@reduxjs/toolkit';

const initialState = {
  taxonomiesLoading: false,
  taxonomiesError: '',
  taxonomiesErrorMessage: '',
  taxonomiesStatusCode: '',
  projects: '',
  projectTypes: '',
  projectType: '',
  skills: '',
  skill: '',
  frameworks: '',
  framework: '',
  technologies: '',
  technology: '',
  description: '',
  icon: '',
  title: '',
  url: '',
  projects: ''
};

export const getProjectTypes = createAsyncThunk('taxonomies/getProjectTypes', async () => {
  try {
    const response = await fetch(`/wp-json/seven-tech/communications/v1/taxonomies/project-types`, {
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

export const getSkills = createAsyncThunk('taxonomies/getSkills', async () => {
  try {
    const response = await fetch(`/wp-json/seven-tech/communications/v1/taxonomies/skills`, {
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


export const getFrameworks = createAsyncThunk('taxonomies/getFrameworks', async () => {
  try {
    const response = await fetch(`/wp-json/seven-tech/communications/v1/taxonomies/frameworks`, {
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

export const getTechnologies = createAsyncThunk('taxonomies/getTechnologies', async () => {
  try {
    const response = await fetch(`/wp-json/seven-tech/communications/v1/taxonomies/technologies`, {
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

export const getProjectType = createAsyncThunk('taxonomies/getProjectType', async (projectType) => {
  try {
    const response = await fetch(`/wp-json/seven-tech/communications/v1/taxonomies/project-types/${projectType}`, {
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

export const getSkill = createAsyncThunk('taxonomies/getSkill', async (skill) => {
  try {
    const response = await fetch(`/wp-json/seven-tech/communications/v1/taxonomies/skills/${skill}`, {
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


export const getFramework = createAsyncThunk('taxonomies/getFramework', async (framework) => {
  try {
    const response = await fetch(`/wp-json/seven-tech/communications/v1/taxonomies/frameworks/${framework}`, {
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

export const getTechnology = createAsyncThunk('taxonomies/getTechnology', async (technology) => {
  try {
    const response = await fetch(`/wp-json/seven-tech/communications/v1/taxonomies/technologies/${technology}`, {
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

export const taxonomiesSlice = createSlice({
  name: 'taxonomies',
  initialState,
  extraReducers: (builder) => {
    builder
      .addCase(getProjectTypes.fulfilled, (state, action) => {
        state.taxonomiesLoading = false;
        state.taxonomiesError = '';
        state.taxonomiesErrorMessage = action.payload.errorMessage;
        state.taxonomiesStatusCode = action.payload.statusCode;
        state.projectTypes = action.payload.projectTypes;
      })
      .addCase(getSkills.fulfilled, (state, action) => {
        state.taxonomiesLoading = false;
        state.taxonomiesError = '';
        state.taxonomiesErrorMessage = action.payload.errorMessage;
        state.taxonomiesStatusCode = action.payload.statusCode;
        state.skills = action.payload.skills;
      })
      .addCase(getFrameworks.fulfilled, (state, action) => {
        state.taxonomiesLoading = false;
        state.taxonomiesError = '';
        state.taxonomiesErrorMessage = action.payload.errorMessage;
        state.taxonomiesStatusCode = action.payload.statusCode;
        state.frameworks = action.payload.frameworks;
      })
      .addCase(getTechnologies.fulfilled, (state, action) => {
        state.taxonomiesLoading = false;
        state.taxonomiesError = '';
        state.taxonomiesErrorMessage = action.payload.errorMessage;
        state.taxonomiesStatusCode = action.payload.statusCode;
        state.technologies = action.payload.technologies;
      })
      .addMatcher(isAnyOf(
        getProjectType.fulfilled,
        getSkill.fulfilled,
        getFramework.fulfilled,
        getTechnology.fulfilled
      ), (state, action) => {
        state.taxonomiesLoading = false;
        state.taxonomiesError = '';
        state.taxonomiesErrorMessage = action.payload.errorMessage;
        state.taxonomiesStatusCode = action.payload.statusCode;
        state.description = action.payload.description;
        state.icon = action.payload.icon;
        state.title = action.payload.title;
        state.url = action.payload.url;
        state.projects = action.payload.projects;
      })
      .addMatcher(isAnyOf(
        getProjectTypes.pending,
        getSkills.pending,
        getFrameworks.pending,
        getTechnologies.pending,
        getProjectType.pending,
        getSkill.pending,
        getFramework.pending,
        getTechnology.pending
      ), (state) => {
        state.taxonomiesLoading = true;
        state.taxonomiesError = '';
        state.taxonomiesErrorMessage = '';
        state.taxonomiesStatusCode = '';
      })
      .addMatcher(isAnyOf(
        getProjectTypes.rejected,
        getSkills.rejected,
        getFrameworks.rejected,
        getTechnologies.rejected,
        getProjectType.rejected,
        getSkill.rejected,
        getFramework.rejected,
        getTechnology.rejected
      ), (state, action) => {
        state.taxonomiesLoading = false;
        state.taxonomiesError = action.error;
        state.taxonomiesErrorMessage = action.error.message;
        state.taxonomiesStatusCode = action.error.code;
      })
  }
})

export default taxonomiesSlice;
