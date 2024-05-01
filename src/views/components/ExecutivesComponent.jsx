import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getExecutives } from '../../controllers/executiveSlice';

import LoadingComponent from './LoadingComponent';
import GroupMembers from './GroupMembers';

function ExecutivesComponent() {
  const {
    executiveLoading,
    executiveError,
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

  return (
    <>
      {Array.isArray(executives) && (
        <>
          <h1 className="title">Executives</h1>

          <GroupMembers group={executives} />
        </>
      )}
    </>
  );
}

export default ExecutivesComponent;
