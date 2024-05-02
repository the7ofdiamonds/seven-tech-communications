import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getFounders } from '../controllers/founderSlice';

import LoadingComponent from '../views/components/LoadingComponent';
import ErrorComponent from '../views/components/ErrorComponent';
import FoundersComponent from '../views/components/FoundersComponent';

function Founders() {
  const {
    founderLoading,
    founderErrorMessage,
    founderStatusCode,
    founders,
  } = useSelector((state) => state.founder);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getFounders());
  }, [dispatch]);

  if (founderLoading) {
    return <LoadingComponent />;
  }

  if (founderErrorMessage) {
    return <ErrorComponent message={founderErrorMessage} />;
  }

  return (
    <>
      <main className="founders">
        <FoundersComponent founders={founders} />
      </main>
    </>
  );
}

export default Founders;
