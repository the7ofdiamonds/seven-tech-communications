import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getFrameworks } from '../controllers/taxonomiesSlice';

import LoadingComponent from './components/LoadingComponent';
import ErrorComponent from './components/ErrorComponent';
import TaxTableComponent from './components/TaxTableComponent';

function Frameworks() {
  const { taxonomiesLoading, taxonomiesErrorMessage, frameworks } =
    useSelector((state) => state.taxonomies);

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getFrameworks());
  }, [dispatch]);

  if (taxonomiesLoading) {
    return <LoadingComponent />;
  }

  if (taxonomiesErrorMessage) {
    return <ErrorComponent message={taxonomiesErrorMessage} />;
  }

  return (
    <main className="frameworks">
      <h1 className="title">frameworks</h1>

      <TaxTableComponent terms={frameworks} />
    </main>
  );
}

export default Frameworks;
