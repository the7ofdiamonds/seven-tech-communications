import React, { useEffect } from 'react';

import GroupMembers from '../components/GroupMembers';

function FoundersComponent(props) {
  const { founders } = props;

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
