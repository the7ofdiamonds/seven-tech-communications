import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getExecutives } from '../controllers/executiveSlice';

import LoadingComponent from '../views/components/LoadingComponent';
import ErrorComponent from '../views/components/ErrorComponent';
import ExecutivesComponent from '../views/components/ExecutivesComponent';

function Executives() {
  const {
    executiveLoading,
    executiveErrorMessage,
    executiveStatusCode,
    executives,
  } = useSelector((state) => state.executive);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getExecutives());
  }, [dispatch]);

  if (executiveLoading) {
    return <LoadingComponent />;
  }

  if (executiveErrorMessage) {
    return <ErrorComponent message={executiveErrorMessage} />;
  }

  return (
    <main className="executives">
      <ExecutivesComponent executives={executives} />
    </main>
  );
}

export default Executives;
