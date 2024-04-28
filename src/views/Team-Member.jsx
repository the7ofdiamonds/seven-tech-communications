import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';

import { getTeamMember } from '../controllers/teamSlice';

import LoadingComponent from './components/LoadingComponent';
import MemberNavigationComponent from './components/MemberNavigationComponent';
import MemberProgrammingSkillsComponent from './components/MemberProgrammingSkillsComponent';
import MemberComponent from './components/MemberComponent';

function TeamMember() {
  const { teammember } = useParams();
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getTeamMember(teammember));
  }, [dispatch, teammember]);

  const {
    teamLoading,
    teamError,
    title,
    avatarURL,
    fullName,
    greeting,
    skills,
    teamResume,
  } = useSelector((state) => state.team);

  if (teamLoading) {
    return <LoadingComponent />;
  }

  return (
    <section className="team-member">
      <MemberNavigationComponent resume={teamResume} />

      <main class="founder">
        <MemberComponent
          title={title}
          avatarURL={avatarURL}
          fullName={fullName}
          greeting={greeting}
        />
      </main>

      <MemberProgrammingSkillsComponent skills={skills} />
    </section>
  );
}

export default TeamMember;
