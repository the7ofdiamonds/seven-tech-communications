import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getTechnologies } from '../controllers/taxonomiesSlice';

import LoadingComponent from './components/LoadingComponent';
import ErrorComponent from './components/ErrorComponent';
import TaxTableComponent from './components/TaxTableComponent';

function Technologies() {
  const { taxonomiesLoading, taxonomiesErrorMessage, technologies } =
    useSelector((state) => state.taxonomies);

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getTechnologies());
  }, [dispatch]);

  if (taxonomiesLoading) {
    return <LoadingComponent />;
  }

  if (taxonomiesErrorMessage) {
    return <ErrorComponent message={taxonomiesErrorMessage} />;
  }

  return (
    <main className="technologies">
      <h1 className="title">technologies</h1>

      <TaxTableComponent terms={technologies} />
    </main>
  );
}

export default Technologies;
