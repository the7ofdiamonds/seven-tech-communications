import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getSkills } from '../controllers/taxonomiesSlice';

import LoadingComponent from './components/LoadingComponent';
import ErrorComponent from './components/ErrorComponent';
import TaxTableComponent from './components/TaxTableComponent';

function Skills() {
  const { taxonomiesLoading, taxonomiesErrorMessage, skills } = useSelector(
    (state) => state.taxonomies
  );

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getSkills());
  }, [dispatch]);

  if (taxonomiesLoading) {
    return <LoadingComponent />;
  }

  if (taxonomiesErrorMessage) {
    return <ErrorComponent message={taxonomiesErrorMessage} />;
  }

  return (
    <main className="skills">
      <h1 className="title">skills</h1>

      <TaxTableComponent terms={skills} />
    </main>
  );
}

export default Skills;
