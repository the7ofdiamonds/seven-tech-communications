import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getTeam } from '../controllers/teamSlice';

import LoadingComponent from './components/LoadingComponent';
import ErrorComponent from './components/ErrorComponent';
import GroupMembers from './components/GroupMembers';

function Team() {
  const { teamLoading, teamErrorMessage, team } = useSelector((state) => state.team);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getTeam());
  }, [dispatch]);

  if (teamLoading) {
    return <LoadingComponent />;
  }

  if (teamErrorMessage) {
    return <ErrorComponent message={teamErrorMessage} />;
  }

  return (
    <>
      <main className="team">
        <h1 className="title">Team</h1>

        <GroupMembers group={team} />
      </main>
    </>
  );
}

export default Team;
