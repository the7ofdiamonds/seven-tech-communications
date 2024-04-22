import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getFounders } from '../controllers/founderSlice';

import LoadingComponent from './components/LoadingComponent';
import GroupMembers from './components/GroupMembers';
import ErrorComponent from './components/ErrorComponent';

function Founders() {
  const {
    founderLoading,
    founderError,
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

  // if(founderError){
  //   return <ErrorComponent message={founderErrorMessage} />;
  // }

  return (
    <>
      <main className="founders">
        {Array.isArray(founders) && (
          <>
            <h4 className="title">Founders</h4>

            <GroupMembers group={founders} />
          </>
        )}
      </main>
    </>
  );
}

export default Founders;
