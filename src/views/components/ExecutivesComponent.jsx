import React, { useEffect } from 'react';

import GroupMembers from './GroupMembers';

function ExecutivesComponent(props) {
  const { executives } = props;

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
