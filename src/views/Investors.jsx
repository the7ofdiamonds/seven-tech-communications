import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getInvestors } from '../controllers/investorSlice';

import LoadingComponent from '../views/components/LoadingComponent';
import ErrorComponent from '../views/components/ErrorComponent';
import GroupMembers from './components/GroupMembers';

function Investors() {
  const {
    investorLoading,
    investorErrorMessage,
    investorStatusCode,
    investors,
  } = useSelector((state) => state.investor);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getInvestors());
  }, [dispatch]);

  if (investorLoading) {
    return <LoadingComponent />;
  }

  if (investorErrorMessage) {
    return <ErrorComponent message={investorErrorMessage} />;
  }

  return (
    <main className="investors">
      {Array.isArray(investors) && (
        <>
          <h1 className="title">Investors</h1>

          <GroupMembers group={investors} />
        </>
      )}
    </main>
  );
}

export default Investors;
