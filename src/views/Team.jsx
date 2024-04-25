import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getTeam } from '../controllers/teamSlice';

import LoadingComponent from './components/LoadingComponent';
import GroupMembers from './components/GroupMembers';

function Team() {
  const { teamLoading, teamError, team } = useSelector((state) => state.team);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getTeam());
  }, [dispatch]);

  if (teamLoading) {
    return <LoadingComponent />;
  }

  return (
    <>
      <main className="team">
        <h4 className="title">Team</h4>

        <GroupMembers group={team} />
      </main>
    </>
  );
}

export default Team;
