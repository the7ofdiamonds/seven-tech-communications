import React from 'react';

import GroupMembers from './GroupMembers';

function ManagingMemberComponent(props) {
  const { ManagingMembers } = props;

  return (
    <>
      {Array.isArray(ManagingMembers) && (
        <>
          <h1 className="title">Managing Members</h1>

          <GroupMembers group={ManagingMembers} />
        </>
      )}
    </>
  );
}

export default ManagingMemberComponent;
