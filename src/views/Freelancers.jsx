import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getFreelancers } from '../controllers/freelancerSlice';

import LoadingComponent from '../views/components/LoadingComponent';
import ErrorComponent from '../views/components/ErrorComponent';

function Freelancers() {
  const {
    freelancerLoading,
    freelancerErrorMessage,
    freelancerStatusCode,
    freelancers,
  } = useSelector((state) => state.freelancer);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getFreelancers());
  }, [dispatch]);

  if (freelancerLoading) {
    return <LoadingComponent />;
  }

  if (freelancerErrorMessage) {
    return <ErrorComponent message={freelancerErrorMessage} />;
  }

  return (
    <main className="freelancers">
      {Array.isArray(freelancers) && (
        <>
          <h1 className="title">Freelancers</h1>

          <GroupMembers group={freelancers} />
        </>
      )}
    </main>
  );
}

export default Freelancers;