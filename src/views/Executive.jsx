import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';

import { getExecutive } from '../controllers/executiveSlice.js';

import LoadingComponent from './components/LoadingComponent.jsx';
import MemberKnowledgeComponent from './components/MemberKnowledgeComponent.jsx';
import MemberComponent from './components/MemberComponent.jsx';
import ContentComponent from './components/ContentComponent.jsx';

import { getContent } from '../controllers/contentSlice.js';

function Executive() {
  const url = new URL(window.location.href);
  const pageSlug = url.pathname;

  const { executive } = useParams();
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getContent(pageSlug));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getExecutive(executive));
  }, [dispatch]);

  const {
    executiveLoading,
    executiveErrorMessage,
    title,
    avatarURL,
    fullName,
    bio,
    projectTypes,
    skills,
    frameworks,
    technologies,
    resume,
  } = useSelector((state) => state.executive);

  const { content } = useSelector((state) => state.content);

  if (executiveLoading) {
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

export default Executive;
