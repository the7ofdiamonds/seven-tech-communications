import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';

import { getFounder } from '../controllers/founderSlice.js';

import LoadingComponent from './components/LoadingComponent';
import MemberProgrammingSkillsComponent from './components/MemberProgrammingSkillsComponent';
import MemberIntroductionComponent from './components/MemberIntroductionComponent';
import ContentComponent from './components/ContentComponent';

import { getContent } from '../controllers/contentSlice';

function Founder() {
  const url = new URL(window.location.href);
  const pageSlug = url.pathname;

  const { founder } = useParams();
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getContent(pageSlug));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getFounder(founder));
  }, [dispatch]);

  const {
    founderLoading,
    founderError,
    title,
    avatarURL,
    fullName,
    greeting,
    skills,
    founder_resume,
  } = useSelector((state) => state.founder);

  const { content } = useSelector((state) => state.content);

  if (founderLoading) {
    return <LoadingComponent />;
  }

  return (
    <>
      <MemberIntroductionComponent
        title={title}
        avatarURL={avatarURL}
        fullName={fullName}
        greeting={greeting}
        founder_resume={founder_resume}
      />

      <ContentComponent content={content} />

      {/* This should be in the portfolio plugin */}
      <MemberProgrammingSkillsComponent skills={skills} />
    </>
  );
}

export default Founder;
