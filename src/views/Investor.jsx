import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';

import { getInvestor } from '../controllers/investorSlice.js';

import LoadingComponent from './components/LoadingComponent.jsx';
import MemberKnowledgeComponent from './components/MemberKnowledgeComponent.jsx';
import MemberComponent from './components/MemberComponent.jsx';
import ContentComponent from './components/ContentComponent.jsx';

import { getContent } from '../controllers/contentSlice.js';

function Investor() {
  const url = new URL(window.location.href);
  const pageSlug = url.pathname;

  const { investor } = useParams();
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getContent(pageSlug));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getInvestor(investor));
  }, [dispatch]);

  const {
    investorLoading,
    investorErrorMessage,
    title,
    avatarURL,
    fullName,
    bio,
    projectTypes,
    skills,
    frameworks,
    technologies,
    resume,
  } = useSelector((state) => state.investor);

  const { content } = useSelector((state) => state.content);

  if (investorLoading) {
    return <LoadingComponent />;
  }
  
  const knowledge = [
    ...(projectTypes || []),
    ...(skills || []),
    ...(frameworks || []),
    ...(technologies || []),
  ];

  return (
    <>
      <main class="author-intro" id="author_intro">
        <MemberComponent
          title={title}
          avatarURL={avatarURL}
          fullName={fullName}
          bio={bio}
          resume={resume}
        />

        <ContentComponent content={content} />

        <MemberKnowledgeComponent knowledge={knowledge} />
      </main>
    </>
  );
}

export default Investor;
