import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getManagingMembers } from '../controllers/managingMemberSlice';

import LoadingComponent from '../views/components/LoadingComponent';
import ErrorComponent from '../views/components/ErrorComponent';
import ManagingMembersComponent from '../views/components/ManagingMemberComponent';

function ManagingMembers() {
  const {
    managingMemberLoading,
    managingMemberErrorMessage,
    managingMemberStatusCode,
    managingMembers,
  } = useSelector((state) => state.managingMember);
  const dispatch = useDispatch();
console.log(managingMembers);
  useEffect(() => {
    dispatch(getManagingMembers());
  }, [dispatch]);

  if (managingMemberLoading) {
    return <LoadingComponent />;
  }

  if (managingMemberErrorMessage) {
    return <ErrorComponent message={managingMemberErrorMessage} />;
  }

  return (
    <main className="managing-members">
      <ManagingMembersComponent ManagingMembers={managingMembers} />
    </main>
  );
}

export default ManagingMembers;
