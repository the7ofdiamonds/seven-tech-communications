import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getFounders } from '../../controllers/founderSlice';

import LoadingComponent from '../components/LoadingComponent';
import GroupMembers from '../components/GroupMembers';

function FoundersComponent() {
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

  return (
    <>
      {Array.isArray(founders) && (
        <>
          <h1 className="title">Founders</h1>

          <GroupMembers group={founders} />
        </>
      )}
    </>
  );
}

export default FoundersComponent;
